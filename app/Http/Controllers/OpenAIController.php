<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI;
use Illuminate\Support\Facades\Log;

class OpenAIController extends Controller
{
    private $systemPrompt = "You are an experienced Registered Behavior Technician (RBT) specializing in treating children with various developmental disorders. Provide insightful summaries of treatment sessions, focusing on key observations, progress, and potential areas for improvement. Your responses should be concise, professional, brief and directly relevant to the patient's treatment. Always format your response as a single paragraph between 2 and 4 lines long. Provide only the summary text without any additional explanations or information. Your tasks will always be to create a brief summary note as an RBT.";

    public function generateSummary(Request $request)
    {
        $request->validate([
            'diagnosis' => 'required|string',
            'birthDate' => 'required|date',
            'startTime' => 'sometimes|nullable|date_format:H:i',
            'endTime' => 'sometimes|nullable|date_format:H:i',
            'startTime2' => 'sometimes|nullable|date_format:H:i',
            'endTime2' => 'sometimes|nullable|date_format:H:i',
            'mood' => 'string',
            'maladaptives' => 'required|array',
            'maladaptives.*.behavior' => 'required|string',
            'maladaptives.*.frequency' => 'required|integer',
            'replacements' => 'required|array',
            'replacements.*.name' => 'required|string',
            'replacements.*.totalTrials' => 'required|integer',
            'replacements.*.correctResponses' => 'required|integer',
            'interventions' => 'required|array',
            'interventions.*' => 'required|string',
        ]);

        $prompt = $this->constructPrompt($request);

        $client = OpenAI::client(env('OPENAI_API_KEY'));

        try {
            $result = $client->chat()->create([
                'model' => env('OPENAI_MODEL'),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $this->systemPrompt,
                    ],
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

            if (isset($result->choices) && is_array($result->choices) && !empty($result->choices)) {
                $generatedText = $result->choices[0]->message->content;
                return response()->json([
                    'summary' => $generatedText,
                ]);
            } else {
                Log::error('Unexpected OpenAI API response structure', [
                    'response' => $result,
                ]);
                return response()->json(['error' => 'Unexpected response from OpenAI API'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function constructPrompt(Request $request): string
    {
        $maladaptives = collect($request->maladaptives)->map(function ($item) {
            return "{$item['behavior']}: {$item['frequency']} times";
        })->implode(', ');

        $replacements = collect($request->replacements)->map(function ($item) {
            return "{$item['name']}: {$item['correctResponses']}/{$item['totalTrials']} correct";
        })->implode(', ');

        $interventions = implode(', ', $request->interventions);

        $prompt = "Create a summary note as an RBT treating a child with {$request->diagnosis} " .
                  "born on {$request->birthDate} using the following data collected during the session(s):\n\n";

        if ($request->startTime && $request->endTime) {
            $prompt .= "Morning session: {$request->startTime} to {$request->endTime}\n";
        }

        if ($request->startTime2 && $request->endTime2) {
            $prompt .= "Afternoon session: {$request->startTime2} to {$request->endTime2}\n";
        }

        if ($request->mood) {
            $prompt .= "Child's mood: {$request->mood}\n";
        }

        $prompt .= "\nMaladaptive behaviors: {$maladaptives}\n" .
                   "Replacement behaviors: {$replacements}\n" .
                   "Interventions used: {$interventions}";

        return $prompt;
    }
}
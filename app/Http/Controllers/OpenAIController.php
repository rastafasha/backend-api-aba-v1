<?php

namespace App\Http\Controllers;

use App\Rules\TimeFormat;
use Illuminate\Http\Request;
use OpenAI;
use Illuminate\Support\Facades\Log;

const SYSTEM_PROMPT =
"You are an experienced expert in Applied Behavior Analysis (ABA), specializing in treating children with various developmental disorders.
Your responses should be concise, professional and directly relevant to the request.
Always format your response as a single paragraph between 3 and 6 lines long.
Provide only the summary text without any additional explanations or information.
Your tasks will always be to create a brief summary for a note as a RBT.
Include all the relevant data in the summary, specially the maladaptives, replacements and interventions, in a brief way, but you don't need to include the patient's data like name, diagnosis, age, etc., nor the session's date or times.
Never include the CPT code in the summary.
The notes should usually start with 'Met with client at...'
Many people's jobs depend on this, I know you can do this!

These are the codes you'll be using:
97151: Behavior identification assessment, administered by a qualified healthcare professional; includes observation and development of treatment plan.
97152: Behavior identification supporting assessment, administered by one technician under the direction of a qualified professional.
97153: Adaptive behavior treatment by protocol, delivered by a technician.
97154: Group adaptive behavior treatment by protocol.
97155: Adaptive behavior treatment with protocol modification, administered by a qualified professional.
97156: Family adaptive behavior treatment guidance.
97157: Multiple-family group adaptive behavior treatment guidance.
97158: Group adaptive behavior treatment with protocol modification.
";
const BCBA_SYSTEM_PROMPT =
"You are an experienced expert in Applied Behavior Analysis (ABA), specializing in treating children with various developmental disorders.
Your responses should be concise, professional and directly relevant to the request.
Always format your response as a single paragraph between 3 and 6 lines long.
Provide only the summary text without any additional explanations or information.
Your tasks will always be to create a brief summary for a note as a BCBA.
Include all the relevant data in the summary, specially the maladaptives, replacements and interventions, in a brief way, but you don't need to include the patient's data like name, diagnosis, age, etc., nor the session's date or times.
Never include the CPT code in the summary.
Many people's jobs depend on this, I know you can do this!

These are the CPT codes you'll be using:
97151: Behavior identification assessment, administered by a qualified healthcare professional; includes observation and development of treatment plan.
97152: Behavior identification supporting assessment, administered by one technician under the direction of a qualified professional.
97153: Adaptive behavior treatment by protocol, delivered by a technician.
97154: Group adaptive behavior treatment by protocol, delivered by a technician.
97155: Adaptive behavior treatment with protocol modification, administered by a qualified professional.
97156: Family adaptive behavior treatment guidance.
97157: Multiple-family group adaptive behavior treatment guidance.
97158: Group adaptive behavior treatment with protocol modification.
";
class OpenAIController extends Controller
{
    private $systemPrompt = SYSTEM_PROMPT;

    private $bcbaSystemPrompt = BCBA_SYSTEM_PROMPT;

    /**
     * @OA\Post(
     *     path="/api/note_rbt/generate-summary",
     *     summary="Generate RBT session summary",
     *     tags={"AI"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"diagnosis", "maladaptives", "replacements", "interventions"},
     *             @OA\Property(property="diagnosis", type="string", description="Patient's diagnosis"),
     *             @OA\Property(property="birthDate", type="string", format="date", description="Patient's birth date"),
     *             @OA\Property(property="startTime", type="string", description="Session start time (HH:MM format)"),
     *             @OA\Property(property="endTime", type="string", description="Session end time (HH:MM format)"),
     *             @OA\Property(property="startTime2", type="string", description="Second session start time (HH:MM format)"),
     *             @OA\Property(property="endTime2", type="string", description="Second session end time (HH:MM format)"),
     *             @OA\Property(property="mood", type="string", description="Patient's mood during session"),
     *             @OA\Property(property="pos", type="string", description="Place of service"),
     *             @OA\Property(property="cpt", type="string", description="CPT code"),
     *             @OA\Property(property="maladaptives", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="behavior", type="string"),
     *                     @OA\Property(property="frequency", type="integer")
     *                 )
     *             ),
     *             @OA\Property(property="replacements", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="name", type="string"),
     *                     @OA\Property(property="totalTrials", type="integer"),
     *                     @OA\Property(property="correctResponses", type="integer")
     *                 )
     *             ),
     *             @OA\Property(property="interventions", type="array", @OA\Items(type="string"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="summary", type="string", description="Generated summary text")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", description="Error message")
     *         )
     *     )
     * )
     */
    public function generateRbtSummary(Request $request)
    {
        $request->validate([
            'diagnosis' => 'required|string',
            'birthDate' => 'sometimes|nullable|date',
            'startTime' => ['sometimes', 'nullable', new TimeFormat()],
            'endTime' => ['sometimes', 'nullable', new TimeFormat()],
            'startTime2' => ['sometimes', 'nullable', new TimeFormat()],
            'endTime2' => ['sometimes', 'nullable', new TimeFormat()],
            'mood' => 'string',
            'pos' => 'string',
            'cpt' => 'string',
            "progressNotedThisSessionComparedToPreviousSession" => 'string',
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

        $prompt = $this->constructRbtPrompt($request);

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

    private function constructRbtPrompt(Request $request): string
    {
        $maladaptives = collect($request->maladaptives)->map(function ($item) {
            return "{$item['behavior']}: {$item['frequency']} times";
        })->implode(', ');

        $replacements = collect($request->replacements)->map(function ($item) {
            return "{$item['name']}: {$item['correctResponses']}/{$item['totalTrials']} correct";
        })->implode(', ');

        $interventions = implode(', ', $request->interventions);

        $prompt = "Create a summary for a note as an RBT treating a child with {$request->diagnosis} ";

        if ($request->birthDate) {
            $prompt .= "born on {$request->birthDate}\n";
        }

        $prompt .= "using the following data collected during the session(s):\n\n";

        if ($request->cpt) {
            $prompt .= "CPT Code: {$request->cpt}\n";
        }
        if ($request->pos) {
            $prompt .= "Place of Service: {$request->pos}\n";
        }
        if ($request->startTime && $request->endTime) {
            $prompt .= "Morning session: {$request->startTime} to {$request->endTime}\n";
        }

        if ($request->startTime2 && $request->endTime2) {
            $prompt .= "Afternoon session: {$request->startTime2} to {$request->endTime2}\n";
        }

        if ($request->mood) {
            $prompt .= "Child's mood: {$request->mood}\n";
        }

        if ($request->progressNotedThisSessionComparedToPreviousSession) {
            $prompt .= "Progress noted this session compared to previous session: {$request->progressNotedThisSessionComparedToPreviousSession}\n";
        }

        $prompt .= "\nMaladaptive behaviors: {$maladaptives}\n" .
            "Replacement behaviors: {$replacements}\n" .
            "Interventions used: {$interventions}";

        return $prompt;
    }



    /**
     * @OA\Post(
     *     path="/api/note_bcba/generate-summary",
     *     summary="Generate BCBA supervision summary",
     *     tags={"AI"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"diagnosis", "caregiverGoals", "rbtTrainingGoals", "noteDescription"},
     *             @OA\Property(property="diagnosis", type="string", description="Patient's diagnosis"),
     *             @OA\Property(property="birthDate", type="string", format="date", description="Patient's birth date"),
     *             @OA\Property(property="startTime", type="string", description="Session start time (HH:MM format)"),
     *             @OA\Property(property="endTime", type="string", description="Session end time (HH:MM format)"),
     *             @OA\Property(property="startTime2", type="string", description="Second session start time (HH:MM format)"),
     *             @OA\Property(property="endTime2", type="string", description="Second session end time (HH:MM format)"),
     *             @OA\Property(property="pos", type="string", description="Place of service"),
     *             @OA\Property(property="cpt", type="string", description="CPT code"),
     *             @OA\Property(property="caregiverGoals", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="goal", type="string"),
     *                     @OA\Property(property="percentCorrect", type="number")
     *                 )
     *             ),
     *             @OA\Property(property="rbtTrainingGoals", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="goal", type="string"),
     *                     @OA\Property(property="percentCorrect", type="number")
     *                 )
     *             ),
     *             @OA\Property(property="noteDescription", type="string", description="Session description")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="summary", type="string", description="Generated summary text")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", description="Error message")
     *         )
     *     )
     * )
     */
    public function generateBcbaSummary(Request $request)
    {
        $request->validate([
            'diagnosis' => 'required|string',
            'birthDate' => 'sometimes|nullable|date',
            'startTime' => ['sometimes', 'nullable', new TimeFormat()],
            'endTime' => ['sometimes', 'nullable', new TimeFormat()],
            'startTime2' => ['sometimes', 'nullable', new TimeFormat()],
            'endTime2' => ['sometimes', 'nullable', new TimeFormat()],
            'pos' => 'string',
            'cpt' => 'string',
            'caregiverGoals' => 'sometimes|array',
            'caregiverGoals.*.goal' => 'required|string',
            'caregiverGoals.*.percentCorrect' => 'required|numeric',
            'rbtTrainingGoals' => 'sometimes|array',
            'rbtTrainingGoals.*.goal' => 'required|string',
            'rbtTrainingGoals.*.percentCorrect' => 'required|numeric',
            // 'noteDescription' => 'required|string',
        ]);

        $prompt = $this->constructBcbaPrompt($request);

        $client = OpenAI::client(env('OPENAI_API_KEY'));

        try {
            $result = $client->chat()->create([
                'model' => env('OPENAI_MODEL'),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $this->bcbaSystemPrompt,
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

    private function constructBcbaPrompt(Request $request): string
    {
        $caregiverGoals = isset($request->caregiverGoals) ?
            collect($request->caregiverGoals)->map(function ($item) {
                return "{$item['goal']}: {$item['percentCorrect']}% correct";
            })->implode(', ') : '';

        $rbtTrainingGoals = isset($request->rbtTrainingGoals) ?
            collect($request->rbtTrainingGoals)->map(function ($item) {
                return "{$item['goal']}: {$item['percentCorrect']}% correct";
            })->implode(', ') : '';

        $prompt = "Create a summary note as Board Certified Behavior Analyst (BCBA) for the treatment of a child with {$request->diagnosis} ";

        if ($request->birthDate) {
            $prompt .= "born on {$request->birthDate}\n";
        }

        $prompt .= "using the following data collected during the BCBA session(s):\n\n";

        if ($request->cpt) {
            $prompt .= "CPT Code: {$request->cpt}\n";
        }
        if ($request->pos) {
            $prompt .= "Place of Service: {$request->pos}\n";
        }
        if ($request->startTime && $request->endTime) {
            $prompt .= "Morning session: {$request->startTime} to {$request->endTime}\n";
        }

        if ($request->startTime2 && $request->endTime2) {
            $prompt .= "Afternoon session: {$request->startTime2} to {$request->endTime2}\n";
        }

        if ($caregiverGoals) {
            $prompt .= "\nCaregiver Training Goals: {$caregiverGoals}\n";
        }
        if ($rbtTrainingGoals) {
            $prompt .= "RBT Training Goals: {$rbtTrainingGoals}\n";
        }
        if (isset($request->noteDescription)) {
            $prompt .= "Session Description: {$request->noteDescription}";
        }

        return $prompt;
    }
}

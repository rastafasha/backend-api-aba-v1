<?php

namespace App\Http\Controllers;

use App\Rules\TimeFormat;
use Illuminate\Http\Request;
use OpenAI;
use Illuminate\Support\Facades\Log;

const BASE_97151 = "
This is a base to build a 97151 note:
BCBA compiled and analyzed data from intake, medical notes, assessments, and client observations.
Reviewed medical records on file.
Analyzed collected data from intake and outcome measures, BCBA started the draft of the background and medical history sections of the treatment plan.
Composed the topographical definitions for maladaptive behaviors. Information will be reported in the final treatment plan.";

const SYSTEM_PROMPT =
"You are an experienced expert in Applied Behavior Analysis (ABA), specializing in treating children with various developmental disorders.
Your responses should be concise, professional and directly relevant to the request.
Always format your response as a single paragraph between 5 and 9 lines long.
Provide only the summary text without any additional explanations or information.
Your tasks will always be to create a brief summary for a note as a RBT.
Include all the relevant data in the summary, specially the maladaptives, replacements and interventions, in a brief way,
but you don't need to include the patient's data like name, diagnosis, age, etc., nor the session's date or times.
Never include the CPT code in the summary.
The notes should usually start with 'Met with client at...'
Many people's jobs depend on this, I know you can do this!

This is the CPT code you'll be using:
97153: Adaptive behavior treatment by protocol, delivered by a technician.
";
const BCBA_SYSTEM_PROMPT =
"You are an experienced expert in Applied Behavior Analysis (ABA), specializing in treating children with various developmental disorders.
Your responses should be concise, professional and directly relevant to the request.
Always format your response as a single paragraph between 3 and 6 lines long, in a professional and clear style.
Provide only the summary text without any additional explanations or information.
Your tasks will always be to create a brief summary for a note as a BCBA.
Include all the relevant data in the summary, specially the maladaptives, replacements and interventions, in a brief way,
but you don't need to include the patient's data like full name, diagnosis, age, etc., nor the session's date or times.
Never include the CPT code in the summary.
Many people's jobs depend on this, I know you can do this!

This is the CPT code you'll be using:
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
     *             @OA\Property(property="participants", type="string", description="Participants"),
     *             @OA\Property(property="startTime", type="string", description="Session start time (HH:MM format)"),
     *             @OA\Property(property="endTime", type="string", description="Session end time (HH:MM format)"),
     *             @OA\Property(property="startTime2", type="string", description="Second session start time (HH:MM format)"),
     *             @OA\Property(property="endTime2", type="string", description="Second session end time (HH:MM format)"),
     *             @OA\Property(property="mood", type="string", description="Patient's mood during session"),
     *             @OA\Property(property="pos", type="string", description="Place of service"),
     *             @OA\Property(property="cpt", type="string", description="CPT code"),
     *             @OA\Property(property="clientResponseToTreatmentThisSession", type="string", description="Patient's response to treatment this session"),
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
            'environmentalChanges' => 'required|string',
            'mood' => 'string',
            'evidencedBy' => 'required|string',
            'pos' => 'required|string',
            'participants' => 'sometimes|string',
            'cpt' => 'string',
            "progressNoted" => 'string',
            'rbtModeledAndDemonstrated' => 'required|string',
            'nextSession' => 'sometimes|nullable|string',
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
        if ($request->participants) {
            $prompt .= "Participants: {$request->participants}\n";
        }
        if ($request->environmentalChanges) {
            $prompt .= "Environmental changes: {$request->environmentalChanges}\n";
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

        if ($request->evidencedBy) {
            $prompt .= "As evidenced by: {$request->evidencedBy}\n";
        }

        if ($request->progressNoted) {
            $prompt .= "Progress noted this session compared to previous session: {$request->progressNoted}\n";
        }

        $prompt .= "\nMaladaptive behaviors: {$maladaptives}\n" .
            "Replacement behaviors: {$replacements}\n" .
            "Interventions used: {$interventions}";

        if ($request->rbtModeledAndDemonstrated) {
            $prompt .= "\nRBT Modeled and demonstrated to caregiver: {$request->rbtModeledAndDemonstrated}";
        }

        if ($request->nextSession) {
            $prompt .= "\nNext session scheduled for: {$request->nextSession}";
        }

        $prompt .= "\nAlso include:\nThe RBT will continue working with the goals as stated in behavior plan.";

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
     *             @OA\Property(property="participants", type="string", description="Participants"),
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
            'participants' => 'sometimes|string',
            'cptCode' => 'string',
            'caregiverGoals' => 'sometimes|nullable|string',
            'rbtTrainingGoals' => 'sometimes|nullable|string',
            'procedure' => 'sometimes|string',
            'instruments' => 'sometimes|string',
            'cpt51type' => 'sometimes|string',
            'intakeAndOutcomeMeasurements' => 'sometimes|string',
            'interventionProtocols' => 'sometimes|nullable|string',
            'replacementProtocols' => 'sometimes|nullable|string',
            'modificationsNeededAtThisTime' => 'sometimes|boolean',
            'additionalGoalsOrInterventions' => 'sometimes|nullable|string',
            'demonstratedInterventionProtocols' => 'sometimes|nullable|string',
            'demonstratedReplacementProtocols' => 'sometimes|nullable|string',
            'discussedBehaviors' => 'sometimes|nullable|string',
            // 'noteDescription' => 'required|string',
        ]);

        $prompt = $this->constructBcbaPrompt($request);

        $client = OpenAI::client(env('OPENAI_API_KEY'));

        $cptDetailed = $request->cptCode . ': ' . $this->getCPTdescription($request->cptCode);

        if ($request->cptCode === '97151') {
            $cptDetailed = $request->cptCode . '\n' . BASE_97151;
        }

        try {
            $result = $client->chat()->create([
                'model' => env('OPENAI_MODEL'),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $this->bcbaSystemPrompt . $cptDetailed,
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
        $rbtTrainingGoals = isset($request->rbtTrainingGoals) ?
            collect($request->rbtTrainingGoals)->map(function ($item) {
                return "{$item['goal']}: {$item['percentCorrect']}% correct";
            })->implode(', ') : '';

        $prompt = "Create a summary note as Board Certified Behavior Analyst (BCBA) for the treatment of a child with {$request->diagnosis} ";

        if ($request->birthDate) {
            $prompt .= "born on {$request->birthDate}, ";
        }

        $prompt .= "using the following data collected during this session:\n\n";

        if ($request->cptCode) {
            $prompt .= "CPT Code: {$request->cptCode}\n";
        }
        if ($request->pos) {
            $prompt .= "Place of Service: {$request->pos}\n";
        }
        if ($request->participants) {
            $prompt .= "Participants: {$request->participants}\n";
        }
        // if ($request->startTime && $request->endTime) {
        //     $prompt .= "Morning session: {$request->startTime} to {$request->endTime}\n";
        // }

        // if ($request->startTime2 && $request->endTime2) {
        //     $prompt .= "Afternoon session: {$request->startTime2} to {$request->endTime2}\n";
        // }

        // if ($caregiverGoals) {
        //     $prompt .= "\nCaregiver Training Goals: {$caregiverGoals}\n";
        // }
        if ($rbtTrainingGoals) {
            $prompt .= "RBT Training Goals: {$rbtTrainingGoals}\n";
        }
        if (isset($request->noteDescription)) {
            $prompt .= "Session Description: {$request->noteDescription}";
        }

        // CPT 97151
        if ($request->cptCode === "97151") {
            if ($request->cpt51type === "observation") {
                $prompt .= "\nType of assessment: Observation";
                $prompt .= "\nProcedure: {$request->procedure}";
                $prompt .= "\nAssessment Tools: {$request->instruments}";
                $prompt .= "\nIntake and Outcome Measurements: {$request->intakeAndOutcomeMeasurements}";
            } elseif ($request->cpt51type === "report") {
                $prompt .= "\nType of assessment: Report\n";
                $prompt .= "\nProcedure: {$request->procedure}\n";
            }
        }

        // CPT 97155
        if ($request->cptCode === "97155") {
            $prompt .= "\nAll the intervention protocols were assessed.";
            if ($request->interventionProtocols && $request->interventionProtocols !== '') {
                $prompt .= "\nIntervention protocols modified: {$request->interventionProtocols}\n";
            }
            if ($request->replacementProtocols && $request->replacementProtocols !== '') {
                $prompt .= "\nReplacement protocols modified: {$request->replacementProtocols}\n";
            }
            if ($request->modificationsNeededAtThisTime) {
                $prompt .= "\nThere were modifications needed at this time\n";
            }
            if ($request->additionalGoalsOrInterventions && $request->additionalGoalsOrInterventions !== '') {
                $prompt .= "\nAdditional goals or interventions: {$request->additionalGoalsOrInterventions}\n";
            }
        }

        // CPT 97156
        if ($request->cptCode === "97156") {
            $prompt .= "\nSession type: Caregiver Training\n";
            if ($request->demonstratedInterventionProtocols && $request->demonstratedInterventionProtocols !== '') {
                $prompt .= "\nDemonstrated intervention protocols: {$request->demonstratedInterventionProtocols}\n";
            }
            if ($request->demonstratedReplacementProtocols && $request->demonstratedReplacementProtocols !== '') {
                $prompt .= "\nDemonstrated replacement protocols: {$request->demonstratedReplacementProtocols}\n";
            }
            if ($request->discussedBehaviors && $request->discussedBehaviors !== '') {
                $prompt .= "\nDiscussed maladaptivebehaviors: {$request->discussedBehaviors}\n";
            }
            if ($request->caregiverGoals && $request->caregiverGoals !== '') {
                $prompt .= "\nCaregiver Training Goals: {$request->caregiverGoals}\n";
            }
        }

        return $prompt;
    }

    private function getCPTdescription($cptCode)
    {
        switch ($cptCode) {
            case "97151":
                return 'Behavior identification assessment, administered by a qualified healthcare professional; includes observation and development of treatment plan.';
            case "97152":
                return 'Behavior identification supporting assessment, administered by one technician under the direction of a qualified professional.';
            case "97153":
                return 'Adaptive behavior treatment by protocol, delivered by a technician.';
            case "97154":
                return 'Group adaptive behavior treatment by protocol, delivered by a technician.';
            case "97155":
                return 'Adaptive behavior treatment with protocol modification, administered by a qualified professional.';
            case "97156":
                return 'Family adaptive behavior treatment guidance.';
            case "97157":
                return 'Multiple-family group adaptive behavior treatment guidance.';
            case "97158":
                return 'Group adaptive behavior treatment with protocol modification.';
            default:
                return 'Unknown CPT code.';
        }
    }
}

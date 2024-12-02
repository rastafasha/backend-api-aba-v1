<?php

namespace App\Http\Controllers\Admin\Graphics;

use DateTime;
use DateInterval;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Notes\NoteRbt;
use App\Models\Patient\Patient;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\Bip\SustitutionGoal;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\Note\NoteRbtResource;
use App\Http\Resources\Note\NoteRbtCollection;

class GraphicReductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function config()
    {
        $users = User::orderBy("id", "desc")->get();

        return response()->json([
            "doctors" => $users->map(function ($user) {
                return [
                    "id" => $user->id,
                    "full_name" => $user->name . ' ' . $user->surname,
                ];
            })
        ]);
    }



    public function configPatients()
    {
        $patients = Patient::orderBy("id", "desc")->get();

        return response()->json([
            "patients" => $patients->map(function ($patients) {
                return [
                    "id" => $patients->id,
                    "full_name" => $patients->first_name . ' ' . $patients->last_name,
                ];
            })
        ]);
    }

    public function show($id)
    {
        $noteRbt = NoteRbt::findOrFail($id);
        $doctor = User::where("status", 'active')->get();

        return response()->json([
            "session_date" => $noteRbt->session_date,
            "interventions" => json_decode($noteRbt->interventions),
            "maladaptives" => json_decode($noteRbt->maladaptives),
            "replacements" => json_decode($noteRbt->replacements)

        ]);
    }


    public function showbyPatientId(Request $request, $patient_identifier)
    {

        $noteRbt = NoteRbt::where("patient_identifier", $request->patient_identifier)->get();


        return response()->json([
            "noteRbt" => NoteRbtCollection::make($noteRbt)


        ]);
    }

    public function showPatientId($patient_identifier)
    {
        $patient = Patient::where("patient_identifier", $patient_identifier)->first();


        return response()->json([
            "patient" => $patient,


        ]);
    }



    public function showGragphicbyMaladaptive(Request $request, string $maladaptives, $patient_identifier)
    {
        // Check if the patient exists
        $patient_is_valid = NoteRbt::where("patient_identifier", $request->patient_identifier)->first();
        $notebypatient = NoteRbt::where("patient_identifier", $request->patient_identifier)
            ->get();

        // Retrieve all NoteRbt records that match the given maladaptive behavior type and patient ID
        $noteRbt = NoteRbt::where('maladaptives', 'LIKE', '%' . $maladaptives . '%')
            ->where("patient_identifier", $patient_identifier)
            ->get();


        // Retrieve all unique session dates from the NoteRbt records
        // $sessions = NoteRbt::pluck('session_date'); // trae toda las fechas

        $sessions = NoteRbt::where('patient_identifier', [$request->patient_identifier])->get();

        //trae la primera y ultima fecha de la semana
        $week_session = NoteRbt::whereNotNull('session_date')->get();

        if ($week_session->isNotEmpty()) {
            $first_date = $week_session->first()->week_session;
            $last_date = $week_session->last()->week_session;

            // Convert the first and last date to Carbon instances
            $first_date = Carbon::parse($first_date);
            $last_date = Carbon::parse($last_date);

            // Get the first and last date of the week
            $first_date_of_week = $first_date->startOfWeek();
            $last_date_of_week = $last_date->endOfWeek();
        }

        // Initialize an empty collection to store the number of occurrences of the given maladaptive behavior type
        $maladaptivesCollection = collect();

        // Get the name of the maladaptive behavior type from the request
        $maladaptive_behavior = $maladaptives;
        // $number_of_occurrences = $maladaptivesCollection->countOccurrenciesInTimeInterval($noteRbt,$number_of_occurrences);


        // Initialize an empty array to store the JSON strings
        $json_strings = [];

        foreach ($noteRbt as $item) {
            // Log::debug("Processing item: ". $item);

            $maladaptivesCollection->push($item->maladaptives);
            Log::debug("maladaptivesCollection: " . $maladaptivesCollection);

            $json_string = str_replace(['[{\"\\\"[', '\\\\\\"',  ']\\\"\"],'], ['[', '\"',  '"]'], $maladaptives);
            // Log::debug("Cleaned JSON string: ". $json_string);

            // Validate JSON string
            $json_error = json_last_error();
            if ($json_error !== JSON_ERROR_NONE) {
                $json_error_message = json_last_error_msg();
                // Log::debug("Invalid JSON string: ". $json_error_message);
                continue;
            }

            // Decode JSON string
            $maladaptives = json_decode($json_string, false, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            if (!is_array($maladaptives)) {
                // Log::debug("Failed to decode JSON: ". json_last_error_msg());
                continue;
            }

            // Process the decoded JSON
            $number_of_occurrences = 0;
            foreach ($maladaptives as $maladaptive) {
                $number_of_occurrences += $maladaptive->number_of_occurrences;
            }
            $maladaptivesCollection->push($number_of_occurrences);

            $maladaptives = json_decode($item->maladaptives, false);

            $mald = json_decode($maladaptives, true);
            foreach ($mald as $m) {
                foreach ($m as $k => $v) {
                    // echo "$k - $v\n";
                }
            }
            function getWeekNumber($session_date)
            {
                $d = new DateTime($session_date);
                return $d->format("W");
            }

            // Define the value you want to filter by
            $filter_value = $maladaptive_behavior;
            // Log::debug("filter_value: " . $filter_value);

            // Filter the maladaptives array
            $filtered_maladaptives = array_filter($mald, function ($maladaptive) use ($filter_value) {
                return $maladaptive['maladaptive_behavior'] == $filter_value;
            });


            $first_date = $sessions->first();

            // $first_date = new DateTime('2024-03-07'); // create a DateTime object for the first date

            $last_date->add(new DateInterval('P7D')); // add 7 days to the first date
            // echo $last_date->format('Y-m-d'); // print the resulting date in the desired format
        }

        // Log::debug("JSON strings: " . json_encode($json_strings, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));




        // Convert maladaptives from string to JSON array
        // $maladaptives = json_decode($item->maladaptives, false);
        // Log::debug("maladaptives: " . $maladaptives);


        $filtered_maladaptives = []; // Initialize as an empty array




        //calcular la semana


        return response()->json([

            // 'decoded' => $mald,
            'maladaptive_behavior' => $maladaptive_behavior, // trae el nombre  del comportamiento que se busco

            // 'maladaptives' => $maladaptives,
            'filtered_maladaptives' => $filtered_maladaptives, // lo filtra pero trae el ultimo
            // 'total_number_of_occurrences' => array_sum(array_column($filtered_maladaptives, 'number_of_occurrences')),
            'total_count_this_in_notes_rbt' => count($maladaptivesCollection), //cuenta el total de este maladative en la nota
            // 'sessions_dates' => $sessions,
            'sessions_dates' => $sessions->map(function ($session) {
                return [
                    'session_date' => $session->session_date,
                    // 'session_date'=> explode(',', $session->session_date)
                    // 'session_date'=> $session=explode(",",$session->session_date)
                ];
            }),

            'maladaptivesCol' => $maladaptivesCollection,


        ], 201);



        if ($maladaptivesCollection->isEmpty()) {
            // Return a 404 Not Found response if the $maladaptivesCollection is empty
            return response()->json(['error' => 'No data found for maladaptive behavior: ' . $maladaptives], 404);
        }

        // return response()->json($response, 201);
    }


    //calcular la semana



    public function showGragphicbyReplacement(Request $request, string $replacements, $patient_identifier)
    {
        // Check if the patient exists
        $patient_is_valid = NoteRbt::where("patient_identifier", $request->patient_identifier)->first();
        $notebypatient = NoteRbt::where("patient_identifier", $request->patient_identifier)
            ->get();
        // Retrieve all NoteRbt records that match the given maladaptive behavior type and patient ID
        $noteRbtGoal = NoteRbt::where('replacements', 'LIKE', '%' . $replacements . '%')
            ->where("patient_identifier", $patient_identifier)
            ->get();

        $searchTerm = 'sustitution_status_sto';
        $sustitutionStatus = SustitutionGoal::where('goalstos', 'LIKE', '%' . $searchTerm . '%')
            ->where("patient_identifier", $patient_identifier)
            ->first();

        $sustitutionStatusStoValues = [];
        $sustitutionStatusStoNameValues = [];
        if ($sustitutionStatus) {
            $goalstos = json_decode($sustitutionStatus->goalstos, true);
            foreach ($goalstos as $goalsto) {
                $sustitutionStatusStoValues[] = $goalsto['sustitution_status_sto'];
                $sustitutionStatusStoNameValues[] = $goalsto['sustitution_sto'];
            }

            // Filter the values after the loop
            $filtered_data = array_filter($sustitutionStatusStoValues, function ($row) {
                return strpos($row, 'inprogress') !== false;
                // return strpos($row, 'initiated') !== false;
                // return strpos($row, 'mastered') !== false;
                // return strpos($row, 'on hold') !== false;
                // return strpos($row, 'discontinued') !== false;
                // return strpos($row, 'maintenance') !== false;
            });

            // Get the indices of the filtered values
            $filtered_indices = array_keys($filtered_data);

            // Filter the names based on the indices
            $filtered_names = array_intersect_key($sustitutionStatusStoNameValues, array_flip($filtered_indices));
        }

        // Retrieve all unique session dates from the NoteRbt records
        // $sessions = NoteRbt::pluck('session_date'); // trae toda las fechas
        $sessions = NoteRbt::where('patient_identifier', [$request->patient_identifier])->get();

        //trae la primera y ultima fecha de la semana
        $week_session = NoteRbt::whereNotNull('session_date')->get();

        if ($week_session->isNotEmpty()) {
            $first_date = $week_session->first()->week_session;
            $last_date = $week_session->last()->week_session;

            // Convert the first and last date to Carbon instances
            $first_date = Carbon::parse($first_date);
            $last_date = Carbon::parse($last_date);

            // Get the first and last date of the week
            $first_date_of_week = $first_date->startOfWeek();
            $last_date_of_week = $last_date->endOfWeek();
        }

        // Initialize an empty collection to store the number of occurrences of the given maladaptive behavior type
        $replacementsCollection = collect();

        // Get the name of the maladaptive behavior type from the request
        $goal = $replacements;
        // $number_of_occurrences = $maladaptivesCollection->countOccurrenciesInTimeInterval($noteRbt,$number_of_occurrences);


        // Initialize an empty array to store the JSON strings
        $json_strings = [];

        foreach ($noteRbtGoal as $item) {
            // Log::debug("Processing item: ". $item);

            $replacementsCollection->push($item->replacements);
            Log::debug("replacementsCollection: " . $replacementsCollection);

            $json_string = str_replace(['[{\"\\\"[', '\\\\\\"',  ']\\\"\"],'], ['[', '\"',  '"]'], $replacements);
            // Log::debug("Cleaned JSON string: ". $json_string);

            // Validate JSON string
            $json_error = json_last_error();
            if ($json_error !== JSON_ERROR_NONE) {
                $json_error_message = json_last_error_msg();
                // Log::debug("Invalid JSON string: ". $json_error_message);
                continue;
            }

            // Decode JSON string
            $replacements = json_decode($json_string, false, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            if (!is_array($replacements)) {
                // Log::debug("Failed to decode JSON: ". json_last_error_msg());
                continue;
            }

            // Process the decoded JSON
            $total_trials = 0;
            foreach ($replacements as $replacement) {
                $total_trials += $replacement->total_trials;
            }
            $replacementsCollection->push($total_trials);

            // Convert replacements from string to JSON array
            $replacements = json_decode($item->replacements, false);
            Log::debug("replacements: " . $replacements);



            $goa = json_decode($replacements, true);
            foreach ($goa as $g) {
                foreach ($g as $k => $v) {
                    // echo "$k - $v\n";
                }
            }
            // Define the value you want to filter by
            $filter_value1 = $goal;
            // Log::debug("filter_value: " . $filter_value1);

            // Filter the maladaptives array
            $filtered_goals = array_filter($goa, function ($goal) use ($filter_value1) {
                return $goal['goal'] == $filter_value1;
            });

            $first_date = $sessions->first();

            // $first_date = new DateTime('2024-03-07'); // create a DateTime object for the first date

            $last_date->add(new DateInterval('P7D')); // add 7 days to the first date
            // echo $last_date->format('Y-m-d'); // print the resulting date in the desired format
        }








        $filtered_data = [];
        $filtered_goals = [];
        $filtered_names = [];

        return response()->json([

            // 'decoded' => $mald,
            'goal' => $goal, // trae el nombre  del comportamiento que se busco
            'sustitutionStatusStoValues' => $sustitutionStatusStoValues,
            'sustitutionStatusStoNameValues' => $sustitutionStatusStoNameValues,
            'datosFiltrados' => $filtered_data,
            'nameSto' => $filtered_names,


            'filtered_goals' => $filtered_goals, // lo filtra pero trae el ultimo
            'total_count_this_in_notes_rbt' => count($replacementsCollection), //cuenta el total de este maladative en la nota
            // 'sessions_dates' => $sessions,
            "sessions_dates" => $sessions->map(function ($session) {
                return [
                    'session_date' => $session->session_date
                ];
            }),

            'replacementsCol' => $replacementsCollection,
            // 'replacementsCol' => json_decode($replacementsCollection),


        ], 201);



        if ($maladaptivesCollection->isEmpty()) {
            // Return a 404 Not Found response if the $maladaptivesCollection is empty
            return response()->json(['error' => 'No data found for maladaptive behavior: ' . $maladaptives], 404);
        }

        // return response()->json($response, 201);
    }


    // public function showGragphicbyReplacement(Request $request, string $replacements ,$patient_id)
    // {
    //     $patient_is_valid = NoteRbt::where("patient_id", $request->patient_id)->first();

    //     $noteRbt = NoteRbt::where('replacements', 'LIKE', '%'.$replacements.'%')
    //     ->where("patient_id", $request->patient_id)->get();

    //     $replacementsCollection = new Collection();

    //     foreach ($noteRbt as $item) {
    //         $replacementsCollection->push($item->replacements);
    //     }

    //     return response()->json([
    //         // "noteRbt" => $noteRbt,

    //         "noteRbt" => NoteRbtCollection::make($noteRbt) ,
    //         // "session_date" =>$noteRbt->session_date,
    //         "replacements" => $replacementsCollection->map(function ($replacem) {
    //             // return $maladaptive;
    //             return json_decode($replacem);
    //             foreach ($replacem as $replac){
    //                 DB::table('note_rbts')->where('replacements','=', $request->replac->goal)->get();
    //             }
    //         })->groupBy("session_date")->toArray()

    //     ],201);




    // }


    public function graphic_patient_month(Request $request)
    {

        $month = $request->month;
        $patient_id = $request->patient_id;

        $query_patient_notes_by_month = DB::table("note_rbts")->where("note_rbts.deleted_at", null)
            ->whereMonth("note_rbts.session_date", $month)
            ->where("note_rbts.patient_id", $patient_id)
            ->join("patients", "note_rbts.patient_id", "=", "patients.patient_id")
            ->select(
                DB::raw("MONTH(note_rbts.session_date) as month"),
            )->groupBy("month")
            ->orderBy("month")
            ->get();

        return response()->json([
            "query_patient_notes_by_month" => $query_patient_notes_by_month,
        ]);
    }

    //     public static function getSalaryMoreThan($salary)
    // {
    //     return self::where('json_details->salary','>',$salary)->get();
    // }

    //     public static function getEmployeesBeforeDate($date)
    //     {
    //         return self::whereDate("json_extract('json_details', '$.doj')", '<', $date)->get()
    //     }
    //     public static function findTotalSalary()
    //     {
    //         return self::select(DB:raw('sum("json_extract('json_details', '$.salary')") as total_salary'))->get();
    //     }
}

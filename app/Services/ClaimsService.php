<?php

namespace App\Services;

use App\Models\Insurance\Insurance;
use App\Models\Notes\NoteBcba;
use App\Models\Notes\NoteRbt;
use App\Models\Patient\Patient;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ClaimsService
{
    private $ediService;

    public function __construct(EdiX12837Service $ediService)
    {
        $this->ediService = $ediService;
    }

    public function generateFromNotes(array $notesRbtIds, array $notesBcbaIds)
    {
        $notesRbtIds = !empty($notesRbtIds) ? $notesRbtIds : [];
        $notesBcbaIds = !empty($notesBcbaIds) ? $notesBcbaIds : [];

        // Get all the notes with their relationships
        $notesRbt = !empty($notesRbtIds) ? NoteRbt::with(['provider', 'supervisor', 'paService', 'location'])->whereIn('id', $notesRbtIds)->get() : collect();
        $notesBcba = !empty($notesBcbaIds) ? NoteBcba::with(['provider', 'supervisor', 'paService', 'location'])->whereIn('id', $notesBcbaIds)->get() : collect();

        // Group notes by patient first
        $rbtNotesByPatient = $notesRbt->groupBy('patient_id');
        $bcbaNotesByPatient = $notesBcba->groupBy('patient_id');

        // Prepare claims data
        $claimsData = [];

        // Process RBT notes
        foreach ($rbtNotesByPatient as $patientId => $patientNotes) {
            $patient = Patient::find($patientId);
            if (!$patient) {
                continue;
            }

            // Further group notes by PA service code and provider
            $notesByPaServiceAndProvider = $patientNotes->groupBy(function ($note) {
                return $note->paService->pa_service . '_' . ($note->provider_id ?? 'null');
            });

            foreach ($notesByPaServiceAndProvider as $groupKey => $notes) {
                if (strpos($groupKey, '_null') !== false) {
                    continue; // Skip notes without provider
                }

                $firstNote = $notes->first();
                if (!$firstNote->paService) {
                    continue; // Skip notes without PA service
                }

                $patientData = $this->getPatientData($patient);
                $insuranceData = $this->getInsuranceData($patient);
                $claimData = $this->getClaimData($patient, $notes, collect(), $insuranceData['services']);

                // Add PA service code to claim data
                $claimData['prior_auth_code'] = $firstNote->paService->pa_service;

                // Add rendering provider information
                $provider = $firstNote->provider;
                if ($provider) {
                    $claimData['rendering_provider_fname'] = $provider->name;
                    $claimData['rendering_provider_lname'] = $provider->surname;
                    $claimData['rendering_provider_npi'] = $provider->npi;
                }

                // Add supervising provider information
                $supervisor = $firstNote->supervisor;
                if ($supervisor) {
                    $claimData['supervising_provider_fname'] = $supervisor->name;
                    $claimData['supervising_provider_lname'] = $supervisor->surname;
                    $claimData['supervising_provider_npi'] = $supervisor->npi;
                }

                $batchData = [
                    'batch_number' => str_pad(mt_rand(1, 999999999), 9, '0', STR_PAD_LEFT),
                    'group_number' => str_pad(mt_rand(1, 999999999), 9, '0', STR_PAD_LEFT),
                ];

                $claimsData[] = array_merge($patientData, $insuranceData, $claimData, $batchData);
            }
        }

        // Process BCBA notes
        foreach ($bcbaNotesByPatient as $patientId => $patientNotes) {
            $patient = Patient::find($patientId);
            if (!$patient) {
                continue;
            }

            // Further group notes by PA service code and provider
            $notesByPaServiceAndProvider = $patientNotes->groupBy(function ($note) {
                return $note->paService->pa_service . '_' . ($note->provider_id ?? 'null');
            });

            foreach ($notesByPaServiceAndProvider as $groupKey => $notes) {
                if (strpos($groupKey, '_null') !== false) {
                    continue; // Skip notes without provider
                }

                $firstNote = $notes->first();
                if (!$firstNote->paService) {
                    continue; // Skip notes without PA service
                }

                $patientData = $this->getPatientData($patient);
                $insuranceData = $this->getInsuranceData($patient);
                $claimData = $this->getClaimData($patient, collect(), $notes, $insuranceData['services']);

                // Add PA service code to claim data
                $claimData['prior_auth_code'] = $firstNote->paService->pa_service;

                // Add rendering provider information
                $provider = $firstNote->provider;
                if ($provider) {
                    $claimData['rendering_provider_fname'] = $provider->name;
                    $claimData['rendering_provider_lname'] = $provider->surname;
                    $claimData['rendering_provider_npi'] = $provider->npi;
                }

                // Add supervising provider information
                $supervisor = $firstNote->supervisor;
                if ($supervisor) {
                    $claimData['supervising_provider_fname'] = $supervisor->name;
                    $claimData['supervising_provider_lname'] = $supervisor->surname;
                    $claimData['supervising_provider_npi'] = $supervisor->npi;
                }

                $batchData = [
                    'batch_number' => str_pad(mt_rand(1, 999999999), 9, '0', STR_PAD_LEFT),
                    'group_number' => str_pad(mt_rand(1, 999999999), 9, '0', STR_PAD_LEFT),
                ];

                $claimsData[] = array_merge($patientData, $insuranceData, $claimData, $batchData);
            }
        }

        Log::info($claimsData);

        if (empty($claimsData)) {
            return '';
        }

        return $this->ediService->generate($claimsData);
    }

    private function getInsuranceData(Patient $patient)
    {
        $insurance = Insurance::where('id', $patient->insurer_id)->first();


        return [
            "payer_name" => $insurance->name,
            "payer_code" => $insurance->payer_id,
            "payer_street" => $insurance->street,
            "payer_street2" => $insurance->street2,
            "payer_city" => $insurance->city,
            "payer_state" => $insurance->state,
            "payer_zip" => $insurance->zip,
            "secondary_payer_name" => '',
            "secondary_payer_code" => '',
            "secondary_payer_street" => '',
            "secondary_payer_street2" => '',
            "secondary_payer_city" => '',
            "secondary_payer_state" => '',
            "secondary_payer_zip" => '',
            "services" => $insurance->services,
        ];
    }

    private function getPatientData(Patient $patient)
    {
        // Determine subscriber info based on is_self_subscriber flag
        $subscriberFirstName = $patient->is_self_subscriber ? $patient->first_name : $patient->parent_guardian_name;
        $subscriberLastName = $patient->is_self_subscriber ? $patient->last_name : explode(' ', $patient->parent_guardian_name)[0];
        $subscriberAddress = $patient->is_self_subscriber ? $patient->address : $patient->parent_address;
        $subscriberCity = $patient->is_self_subscriber ? $patient->city : $patient->parent_city;
        $subscriberState = $patient->is_self_subscriber ? $patient->state : $patient->parent_state;
        $subscriberZip = $patient->is_self_subscriber ? $patient->zip : $patient->parent_zip;
        $subscriberGender = $patient->is_self_subscriber ? $patient->gender : $patient->parent_gender;
        $subscriberDob = $patient->is_self_subscriber ? $patient->birth_date : $patient->parent_birth_date;

        return [
            "patient_id" => $patient->patient_identifier,
            "subscriber_fname" => $subscriberFirstName,
            "subscriber_mname" => '',
            'subscriber_policy_number' => '123456789', // TODO: Get from insurance
            "subscriber_lname" => $subscriberLastName,
            "subscriber_relationship" => $patient->is_self_subscriber ? 'self' : $patient->relationship,
            "subscriber_gender" => $subscriberGender === 1 ? 'M' : 'F',
            "subscriber_address" => $subscriberAddress,
            "subscriber_address2" => '',
            "subscriber_dob" => $subscriberDob ? Carbon::parse($subscriberDob)->format('Ymd') : '',
            "subscriber_city" => $subscriberCity ?? '',
            "subscriber_state" => $subscriberState,
            "subscriber_zip" => $subscriberZip,
            'primary_problem_type_code' => 'ICD10',
            'primary_problem_code' => $patient->diagnosis_code,
            'patient_encounter_date' => '',  // First session date
            'patient_first_encounter_date' => '',  // Initial evaluation date
            'patient_last_visit_date' => '',  // Last session date
            'patient_admission_date' => '',
            'patient_discharge_date' => '',
            'patient_paid_amt' => '',  // Total paid amount
            'prior_auth_code' => '',  // ABA therapy typically requires prior authorization
            'original_claim_number' => '',
            'insurance_type_code' => 'CI',
            'claim_type' => '1',
            'claim_notes' => '',  // Notes
            'other_diag_list' => [],
            'procedure_codes' => [],
            'ref_physician_lname' => $patient->referring_provider_last_name,  // Referring physician
            'ref_physician_fname' => $patient->referring_provider_first_name,
            'ref_physician_mname' => '',
            'ref_physician_npi' => $patient->referring_provider_npi,
            'referral_number' => '',
        ];
    }

    private function getClaimData(Patient $patient, Collection $notesRbt, Collection $notesBcba, array $services)
    {
        // Get location from the first note (either RBT or BCBA)
        $location = null;
        if ($notesRbt->isNotEmpty()) {
            $location = $notesRbt->first()->location;
        } elseif ($notesBcba->isNotEmpty()) {
            $location = $notesBcba->first()->location;
        }

        if (!$location) {
            throw new \Exception('No location found for the notes');
        }

        $baseClaimData = [
            'x12_sender_id' => $location->providerId ?? 'M12V4',
            'x12_reciever_id' => 'CLAIMMD',
            'x12_version' => '005010X222A1',
            'submitter_org_name' => $location->title,
            'submitter_name' => $location->title,
            'submitter_telephone' => $location->phone1,
            'submitter_email' => $location->email,
            'submitter_tax_id' => $location->taxid,
            'billing_provider_lastname' => $location->title,
            'billing_provider_npi' => $location->npi ?? '123456789',
            'billing_provider_street' => $location->address,
            'billing_provider_street2' => $location->address2,
            'billing_provider_city' => $location->city,
            'billing_provider_state' => $location->state,
            'billing_provider_zip' => $location->zip,
            'billing_provider_federal_taxid' => $location->taxid ?? '123456789',
            'biller_tax_code' => $location->taxonomy ?? '103K00000X',
            'claim_type' => '1',
            'transcode' => '837P',
        ];

        $procedureCodes = [];
        $totalAmount = 0;

        // Process RBT notes
        foreach ($notesRbt as $note) {
            $noteData = $this->getClaimDataFromRbtNote($note);
            $service = collect($services)->firstWhere('code', $noteData['cpt_codes']);

            if (!$service) {
                continue;
            }

            $noteTotalAmount = $noteData['quantity'] * $service['unit_prize'];
            $totalAmount += $noteTotalAmount;

            $procedureCodes[] = [
                'cpt_codes' => $noteData['cpt_codes'],
                'cpt_charge' => number_format($noteTotalAmount, 2, '.', ''),
                'code_pointer' => '1',
                'dos' => $noteData['dos'],
                'quantity' => $noteData['quantity'],
                'total_amount' => number_format($noteTotalAmount, 2, '.', ''),
                'facility_code' => '11'
            ];
        }

        // Process BCBA notes
        foreach ($notesBcba as $note) {
            $noteData = $this->getClaimDataFromBcbaNote($note);
            $service = collect($services)->firstWhere('code', $noteData['cpt_codes']);

            if (!$service) {
                continue;
            }

            $noteTotalAmount = $noteData['quantity'] * $service['unit_prize'];
            $totalAmount += $noteTotalAmount;

            $procedureCodes[] = [
                'cpt_codes' => $noteData['cpt_codes'],
                'cpt_charge' => number_format($noteTotalAmount, 2, '.', ''),
                'code_pointer' => '1',
                'dos' => $noteData['dos'],
                'quantity' => $noteData['quantity'],
                'total_amount' => number_format($noteTotalAmount, 2, '.', ''),
                'facility_code' => '11'
            ];
        }

        return array_merge($baseClaimData, [
            'procedure_codes' => $procedureCodes,
            'total_amount' => number_format($totalAmount, 2, '.', '')
        ]);
    }

    private function getClaimDataFromBcbaNote(NoteBcba $note)
    {
        return [
            'cpt_codes' => $note->cpt_code,
            'quantity' => $note->total_units,
            'dos' => Carbon::parse($note->session_date)->format('Ymd'),
        ];
    }

    private function getClaimDataFromRbtNote(NoteRbt $note)
    {
        return [
            'cpt_codes' => $note->cpt_code,
            'quantity' => $note->total_units,
            'dos' => Carbon::parse($note->session_date)->format('Ymd'),
        ];
    }
}

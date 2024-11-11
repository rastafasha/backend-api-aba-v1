<?php

namespace App\Services;

use App\Models\Insurance\Insurance;
use App\Models\Notes\NoteBcba;
use App\Models\Notes\NoteRbt;
use App\Models\Patient\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class ClaimsService
{
  private $ediService;

  public function __construct(EdiX12837Service $ediService)
  {
    $this->ediService = $ediService;
  }

  public function generateFromNotes(array $notesRbtIds, array $notesBcbaIds)
    {
        // Ensure there's an array of either RBT or BCBA note ids.
        $notesRbtIds = !empty($notesRbtIds) ? $notesRbtIds : [];
        $notesBcbaIds = !empty($notesBcbaIds) ? $notesBcbaIds : [];

        // Get all the notes for the given ids.
        $notesRbt = !empty($notesRbtIds) ? NoteRbt::with('provider')->whereIn('id', $notesRbtIds)->get() : collect();
        $notesBcba = !empty($notesBcbaIds) ? NoteBcba::whereIn('id', $notesBcbaIds)->get() : collect();


        // Group notes by patient
        $rbtNotesByPatient = $notesRbt->groupBy('patient_id');
        $bcbaNotesByPatient = $notesBcba->groupBy('patient_id');

        // Prepare claims data
        $claimsData = [];

        // Process RBT notes
        foreach ($rbtNotesByPatient as $patientId => $notes) {
            $patient = Patient::where('patient_id', $patientId)->first();
            if (!$patient) continue;

            $patientData = $this->getPatientData($patient);
            $insuranceData = $this->getInsuranceData($patient);
            $claimData = $this->getClaimData($patient, $notes, collect(), $insuranceData['services']);

            $batchData = [
                'batch_number' => str_pad(mt_rand(1, 999999999), 9, '0', STR_PAD_LEFT),
                'group_number' => str_pad(mt_rand(1, 999999999), 9, '0', STR_PAD_LEFT),
            ];

            $claimsData[] = array_merge($patientData, $insuranceData, $claimData, $batchData);
        }

        // Process BCBA notes
        foreach ($bcbaNotesByPatient as $patientId => $notes) {
            $patient = Patient::where('patient_id', $patientId)->first();
            if (!$patient) continue;

            $patientData = $this->getPatientData($patient);
            $insuranceData = $this->getInsuranceData($patient);
            $claimData = $this->getClaimData($patient, collect(), $notes, $insuranceData['services']);

            $batchData = [
                'batch_number' => str_pad(mt_rand(1, 999999999), 9, '0', STR_PAD_LEFT),
                'group_number' => str_pad(mt_rand(1, 999999999), 9, '0', STR_PAD_LEFT),
            ];

            $claimsData[] = array_merge($patientData, $insuranceData, $claimData, $batchData);
        }

        if (empty($claimsData)) {
            return response()->json(['error' => 'No valid claims found'], 400);
        }

        $fileContent = $this->ediService->generate($claimsData);

        return $fileContent;
    }

    private function getInsuranceData(Patient $patient)
    {
        $insurance = Insurance::where('id', $patient->insurer_id)->first();


        return [
            "payer_name" => $insurance->insurer_name,
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
        return [
            "patient_id" => $patient->patient_id,
            "subscriber_fname" => $patient->first_name,
            "subscriber_mname" => '',
            'subscriber_policy_number' => $patient->patient_id ?? '',
            "subscriber_lname" => $patient->last_name,
            "subscriber_relationship" => $patient->relationship,
            "subscriber_gender" => $patient->gender === 1 ? 'M' : 'F',
            "subscriber_address" => $patient->address,
            "subscriber_address2" => '',
            "subscriber_dob" => $patient->birth_date ? Carbon::parse($patient->birth_date)->format('m-d-Y') : '',
            "subscriber_city" => $patient->city ?? '',
            "subscriber_state" => $patient->state,
            "subscriber_zip" => $patient->zip,
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
            'ref_physician_lname' => '',  // Referring physician
            'ref_physician_fname' => '',
            'ref_physician_mname' => '',
            'ref_physician_npi' => '',
            'referral_number' => '',
        ];
    }

    private function getClaimData(Patient $patient, Collection $notesRbt, Collection $notesBcba, array $services)
    {
        $baseClaimData = [
            // Sender/Submitter Information
            'x12_sender_id' => '19188',
            'x12_reciever_id' => 'CLAIMMD',
            'x12_version' => '005010X222A1',
            'submitter_org_name' => 'ABA OF SOUTHWEST FLORIDA CORP',
            'submitter_name' => 'ABA OF SOUTHWEST FLORIDA CORP',
            'submitter_telephone' => '8007054849',
            'submitter_email' => 'OFFICE@ABAOFSWF.COM',
            'submitter_tax_id' => '830711082',

            // Billing Provider Information
            'billing_provider_lastname' => 'ABA OF SOUTHWEST FLORIDA CORP',
            'billing_provider_npi' => '1679065429',
            'billing_provider_street' => '6660 ESTERO BLVD',
            'billing_provider_street2' => 'B404',
            'billing_provider_city' => 'FORT MYERS BEACH',
            'billing_provider_state' => 'FL',
            'billing_provider_zip' => '339314524',
            'billing_provider_federal_taxid' => '830711082',
            'biller_tax_code' => '103K00000X',

            // Default claim settings
            'claim_type' => '1',
            'transcode' => '837P',
        ];

        $procedureCodes = [];
        $totalAmount = 0;

        // Get the claim data from the RBT notes
        foreach ($notesRbt as $note) {
            $noteData = $this->getClaimDataFromRbtNote($note);
            $service = array_filter($services, function ($service) use ($noteData) {
                return $service['code'] == $noteData['cpt_codes'];
            });
            if (!$service) {
                continue;
            }

            $noteTotalAmount = $note->total_units * $service[0]['unit_prize'];

            $procedureCodes[] = [
                'cpt_codes' => $noteData['cpt_codes'],
                'cpt_charge' => $noteTotalAmount,
                'code_pointer' => '1',
                'dos' => $noteData['dos'],
                'quantity' => $noteData['quantity'],
                'total_amount' => $noteTotalAmount,
                'facility_code' => '11'  // Office setting
            ];
            $totalAmount += $noteTotalAmount;
        }

        // Get the claim data from the BCBA notes
        foreach ($notesBcba as $note) {
            $noteData = $this->getClaimDataFromBcbaNote($note);
            $service = array_filter($services, function ($service) use ($noteData) {
                return $service['code'] == $noteData['cpt_codes'];
            });
            if (!$service) {
                continue;
            }

            $noteTotalAmount = $note->total_units * $service[0]['unit_prize'];

            $procedureCodes[] = [
                'cpt_codes' => $noteData['cpt_codes'],
                'cpt_charge' => $noteTotalAmount,
                'code_pointer' => '1',
                'dos' => $noteData['dos'],
                'quantity' => $noteData['quantity'],
                'total_amount' => $noteTotalAmount,
                'facility_code' => '11'  // Office setting
            ];
            $totalAmount += $noteTotalAmount;
        }

        return array_merge($baseClaimData, [
            'procedure_codes' => $procedureCodes,
            'total_amount' => $totalAmount
        ]);
    }

    private function getClaimDataFromBcbaNote(NoteBcba $note)
    {
        return [
            'cpt_codes' => $note->cpt_code,
            'quantity' => $note->total_units,
            'dos' => Carbon::parse($note->session_date)->format('m-d-Y'),

            // Rendering Provider Information
            'rendering_provider_lname' => 'placeholder',
            'rendering_provider_fname' => 'Sarah',
            'rendering_provider_mname' => '',
            'rendering_provider_npi' => '4567890123',
        ];
    }

    private function getClaimDataFromRbtNote(NoteRbt $note)
    {
        return [
            'cpt_codes' => $note->cpt_code,
            'quantity' => $note->total_units,
            'dos' => Carbon::parse($note->session_date)->format('m-d-Y'),
        ];
    }
}

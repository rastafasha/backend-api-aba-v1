<?php

namespace App\Http\Controllers;

use App\Models\Notes\NoteRbt;
use App\Models\Notes\NoteBcba;
use App\Models\Patient\Patient;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class PDFController extends Controller
{
    public function generatePDF()
    {
        $data = [
            'title' => 'Welcome to Our Application',
            'date' => date('m/d/Y')
        ];

        $pdf = PDF::loadView('pdf.test', $data);

        return $pdf->download('test.pdf');

        // Alternatively, to display in browser:
        // return $pdf->stream('test.pdf');
    }

    public function generateRbtNotePDF($id)
    {
        $note = NoteRbt::with([
            'patient',
            'provider',
            'supervisor',
            'location',
            'insurance'
        ])->findOrFail($id);

        $data = [
            'note' => $note,
            'title' => 'APPOINTMENT NOTE',
            'date' => date('m/d/Y'),
            'center_name' => config('app.name', 'Your Center Name'),
            'center_address' => '123 Main Street',
            'center_city' => 'City, State ZIP',
            'center_phone' => '(555) 555-5555'
        ];

        $pdf = PDF::loadView('pdf.rbt-note', $data)->setPaper('a4', 'portrait');

        return $pdf->download('rbt-note-' . $note->id . '.pdf');
    }

    public function generateBcbaNotePDF($id)
    {
        $note = NoteBcba::with([
            'patient',
            'provider',
            'supervisor',
            'location',
            'insurance'
        ])->findOrFail($id);

        $data = [
            'note' => $note,
            'title' => 'BCBA SUPERVISION NOTE',
            'date' => date('m/d/Y')
        ];

        $pdf = PDF::loadView('pdf.bcba-note', $data)->setPaper('a4', 'portrait');

        return $pdf->download('bcba-note-' . $note->id . '.pdf');
    }

    /**
     * Generate a PDF of the patient's profile
     *
     * @param int $patientId
     * @return \Illuminate\Http\Response
     */
    public function generatePatientProfile($patientId)
    {
        try {
            // Load the patient with necessary relationships
            $patient = Patient::with([
                'paServices',
                'locals',
                'insurances',
                'insurance_secondary',
                'rbt_home:id,name,surname',
                'rbt2_school:id,name,surname',
                'bcba_home:id,name,surname',
                'bcba2_school:id,name,surname',
                'clin_director:id,name,surname'
            ])->findOrFail($patientId);

            // Add computed properties
            $patient->insurer_name = $patient->insurance->name ?? 'N/A';
            $patient->insurer_name_secondary = $patient->insurance_secondary->name ?? 'N/A';

            // Generate PDF
            $pdf = PDF::loadView('pdf.patient-profile', [
                'patient' => $patient
            ]);

            // Set paper size and orientation
            $pdf->setPaper('a4', 'portrait');

            // Optional: Set PDF metadata
            $pdf->setOption([
                'title' => 'Patient Profile - ' . $patient->first_name . ' ' . $patient->last_name,
                'subject' => 'Patient Profile Report',
                'creator' => 'ABA System',
                'author' => 'ABA System'
            ]);

            // Return the PDF for download
            return $pdf->download('patient-profile-' . $patient->patient_identifier . '.pdf');
        } catch (\Exception $e) {
            // Log the error
            Log::error('PDF Generation Error: ' . $e->getMessage());

            // Return error response
            return response()->json([
                'message' => 'Error generating PDF',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Stream the PDF in the browser instead of downloading
     *
     * @param int $patientId
     * @return \Illuminate\Http\Response
     */
    public function streamPatientProfile($patientId)
    {
        try {
            $patient = Patient::with([
                'pa_services',
                'locals',
                'insurer:id,name',
                'insurance_secondary:id,name',
                'rbt_home:id,name,surname',
                'rbt2_school:id,name,surname',
                'bcba_home:id,name,surname',
                'bcba2_school:id,name,surname',
                'clin_director:id,name,surname'
            ])->findOrFail($patientId);


            $pdf = PDF::loadView('pdf.patient-profile', [
                'patient' => $patient
            ]);

            $pdf->setPaper('a4', 'portrait');

            // Stream the PDF in the browser
            return $pdf->stream('patient-profile-' . $patient->patient_identifier . '.pdf');
        } catch (\Exception $e) {
            Log::error('PDF Generation Error: ' . $e->getMessage());

            return response()->json([
                'message' => 'Error generating PDF',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

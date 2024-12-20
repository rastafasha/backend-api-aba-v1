<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;

Route::get('/generate-pdf', [PDFController::class, 'generatePDF'])
    ->name('generatePDF');

Route::get('/v2/note_rbt/pdf/{id}', [PDFController::class, 'generateRbtNotePDF'])
    ->name('generateRbtNotePDF');

Route::get('/v2/note_bcba/pdf/{id}', [PDFController::class, 'generateBcbaNotePDF'])
    ->name('generateBcbaNotePDF');

Route::get('/v2/patient/{patientId}/profile/pdf', [PDFController::class, 'generatePatientProfile'])
    ->name('patient.profile.pdf');

Route::get('/v2/patient/{patientId}/profile/stream', [PDFController::class, 'streamPatientProfile'])
    ->name('patient.profile.pdf.stream');

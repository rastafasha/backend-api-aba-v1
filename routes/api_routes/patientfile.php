<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Patient\PatientFileController;

    Route::get('/patient_file', [PatientFileController::class, 'index'])->name('patientFile.index');

    Route::get('/patient_file/showBypatient/{id}', [PatientFileController::class, 'showByPatient'])->name('patientfile.showByPatient');
    Route::post('/patient_file/store', [PatientFileController::class, 'store'])->name('patientfile.store');
    Route::post('/patient_file/update/{id}', [PatientFileController::class, 'update'])->name('patientfile.update');
    Route::delete('/patient_file/delete-file/{id}', [PatientFileController::class, 'destroy'])->name('patientfile.destroy');

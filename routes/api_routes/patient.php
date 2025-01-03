<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\Patient\PatientV2Controller;

Route::get('patients', [PatientController::class, 'index'])->name('patients.index');
Route::get('patients/show/{id}', [PatientController::class, 'show'])->name('patients.show');
Route::get('patients/all', [PatientController::class, 'all'])->name('patients.all');
Route::get('patients/profile/{id}', [PatientController::class, 'profile'])->name('patients.profile');
Route::get('patients/shobypatientid/{patient}', [PatientController::class, 'showPatientId'])->name('patients.showPatientId');
Route::get('patients/shobypatienLocation/{location_id}', [PatientController::class, 'showPatientbyLocation'])->name('patients.showPatientbyLocation');

Route::get('patients/byDoctor/{doctor_id}', [PatientController::class, 'patientsByDoctor'])->name('patient.patientsByDoctor');
Route::get('patients/check-email-exist/{email}', [PatientController::class, 'emailExist'])->name('patient.emailExist');

Route::get('patients/config/{location_id}', [PatientController::class, 'config'])->name('patients.config');



Route::post('patients/store', [PatientV2Controller::class, 'store'])->name('patients.store');
Route::post('patients/update/{patient}', [PatientController::class, 'update'])->name('patients.update');
Route::post('patients/patientupdate/{patient}', [PatientController::class, 'patientUpdate'])->name('patients.patientUpdate');
Route::delete('patients/destroy/{id}', [PatientController::class, 'destroy'])->name('patients.destroy');

Route::put('/patients/update/eligibility/{patient:id}', [PatientController::class, 'updateEligibility'])
    ->name('patients.updateEligibility');

Route::prefix('v2/patients')->group(function () {
    Route::get('/', [PatientV2Controller::class, 'index']);
    Route::post('/', [PatientV2Controller::class, 'store']);
    Route::get('/{id}', [PatientV2Controller::class, 'show']);
    Route::put('/{id}', [PatientV2Controller::class, 'update']);
    Route::delete('/{id}', [PatientV2Controller::class, 'destroy']);
});

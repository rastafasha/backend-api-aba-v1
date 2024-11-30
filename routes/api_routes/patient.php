<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\Patient\PatientV2Controller;

Route::get('patients', [PatientController::class, 'index'])->name('index');
Route::get('patients/show/{id}', [PatientController::class, 'show'])->name('show');
Route::get('patients/all', [PatientController::class, 'all'])->name('all');
Route::get('patients/profile/{id}', [PatientController::class, 'profile'])->name('profile');
Route::get('patients/shobypatientid/{patient}', [PatientController::class, 'showPatientId'])->name('showPatientId');
Route::get('patients/shobypatienLocation/{location_id}', [PatientController::class, 'showPatientbyLocation'])->name('showPatientbyLocation');

Route::get('patients/byDoctor/{doctor_id}', [PatientController::class, 'patientsByDoctor'])->name('patientsByDoctor');
Route::get('patients/check-email-exist/{email}', [PatientController::class, 'emailExist'])->name('emailExist');

Route::get('patients/config/{location_id}', [PatientController::class, 'config'])->name('config');



Route::post('patients/store', [PatientV2Controller::class, 'store'])->name('store');
Route::post('patients/update/{patient}', [PatientController::class, 'update'])->name('update');
Route::post('patients/patientupdate/{patient}', [PatientController::class, 'patientUpdate'])->name('patientUpdate');
Route::delete('patients/destroy/{id}', [PatientController::class, 'destroy'])->name('destroy');

Route::put('/patients/update/eligibility/{patient:id}', [PatientController::class, 'updateEligibility'])
    ->name('patients.updateEligibility');

Route::prefix('v2/patients')->group(function () {
    Route::get('/', [PatientV2Controller::class, 'index']);
    Route::post('/', [PatientV2Controller::class, 'store']);
    Route::get('/{id}', [PatientV2Controller::class, 'show']);
    Route::put('/{id}', [PatientV2Controller::class, 'update']);
    Route::delete('/{id}', [PatientV2Controller::class, 'destroy']);
});

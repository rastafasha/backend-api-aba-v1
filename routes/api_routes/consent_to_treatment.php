<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Bip\ConsentToTreatmentController;

Route::get('consenttotreatment', [ConsentToTreatmentController::class, 'index'])->name('consent_to_treatments.index');
Route::get('consenttotreatment/show/{id}', [ConsentToTreatmentController::class, 'show'])->name('consent_to_treatments.show');
Route::get('consenttotreatment/profile/{id}', [ConsentToTreatmentController::class, 'showbyProfile'])->name('consent_to_treatments.showbyProfile');
Route::get('consenttotreatment/showgbyPatientId/{patient_id}', [ConsentToTreatmentController::class, 'showgbyPatientId'])->name('consent_to_treatments.showgbyPatientId');

Route::post('consenttotreatment/store', [ConsentToTreatmentController::class, 'store'])->name('consent_to_treatments.store');
Route::post('consenttotreatment/update/{goal}', [ConsentToTreatmentController::class, 'update'])->name('consent_to_treatments.update');
Route::delete('consenttotreatment/destroy/{id}', [ConsentToTreatmentController::class, 'destroy'])->name('consent_to_treatments.destroy');

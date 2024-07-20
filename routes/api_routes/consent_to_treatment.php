<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Bip\ConsentToTreatmentController;

Route::get('consenttotreatment', [ConsentToTreatmentController::class, 'index'])->name('index');
Route::get('consenttotreatment/show/{id}', [ConsentToTreatmentController::class, 'show'])->name('show');
Route::get('consenttotreatment/profile/{id}', [ConsentToTreatmentController::class, 'showbyProfile'])->name('showbyProfile');
Route::get('consenttotreatment/showgbyPatientId/{patient_id}', [ConsentToTreatmentController::class, 'showgbyPatientId'])->name('showgbyPatientId');

Route::post('consenttotreatment/store', [ConsentToTreatmentController::class, 'store'])->name('store');
Route::post('consenttotreatment/update/{goal}', [ConsentToTreatmentController::class, 'update'])->name('update');
Route::delete('consenttotreatment/destroy/{id}', [ConsentToTreatmentController::class, 'destroy'])->name('destroy');


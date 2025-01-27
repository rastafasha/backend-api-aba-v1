<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Bip\ConsentToTreatmentController;
use App\Http\Controllers\Admin\Bip\ConsentToTreatmentV2Controller;

// V1 Routes
Route::get('consenttotreatment', [ConsentToTreatmentController::class, 'index'])->name('consenttotreatment.index');
Route::get('consenttotreatment/show/{id}', [ConsentToTreatmentController::class, 'show'])->name('consenttotreatment.show');
Route::get('consenttotreatment/profile/{id}', [ConsentToTreatmentController::class, 'showbyProfile'])->name('consenttotreatment.showbyProfile');
Route::get('consenttotreatment/showgbyPatientId/{patient_id}', [ConsentToTreatmentController::class, 'showgbyPatientId'])->name('showgbyPatientId');

Route::post('consenttotreatment/store', [ConsentToTreatmentController::class, 'store'])->name('consenttotreatment.store');
Route::post('consenttotreatment/update/{goal}', [ConsentToTreatmentController::class, 'update'])->name('consenttotreatment.update');
Route::delete('consenttotreatment/destroy/{id}', [ConsentToTreatmentController::class, 'destroy'])->name('consenttotreatment.destroy');

// V2 Routes
Route::prefix('v2')->group(function () {
    Route::get('consent-to-treatments', [ConsentToTreatmentV2Controller::class, 'index']);
    Route::post('consent-to-treatments', [ConsentToTreatmentV2Controller::class, 'store']);
    Route::get('consent-to-treatments/{id}', [ConsentToTreatmentV2Controller::class, 'show']);
    Route::put('consent-to-treatments/{id}', [ConsentToTreatmentV2Controller::class, 'update']);
    Route::delete('consent-to-treatments/{id}', [ConsentToTreatmentV2Controller::class, 'destroy']);
});

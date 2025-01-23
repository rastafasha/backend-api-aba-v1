<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Bip\GeneralizationTrainingController;
use App\Http\Controllers\Admin\Bip\GeneralizationTrainingV2Controller;

Route::get('generalizationtraining', [GeneralizationTrainingController::class, 'index'])->name('generalizationtraining.index');
Route::get('generalizationtraining/show/{id}', [GeneralizationTrainingController::class, 'show'])->name('generalizationtraining.show');
Route::get('generalizationtraining/profile/{id}', [GeneralizationTrainingController::class, 'showbyProfile'])->name('generalizationtraining.showbyProfile');
Route::get('generalizationtraining/showgbyPatientId/{patient_id}', [GeneralizationTrainingController::class, 'showgbyPatientId'])->name('showgbyPatientId');

Route::post('generalizationtraining/store', [GeneralizationTrainingController::class, 'store'])->name('generalizationtraining.store');
Route::post('generalizationtraining/update/{goal}', [GeneralizationTrainingController::class, 'update'])->name('generalizationtraining.update');
Route::delete('generalizationtraining/destroy/{id}', [GeneralizationTrainingController::class, 'destroy'])->name('generalizationtraining.destroy');

// V2 Routes
Route::prefix('v2')->group(function () {
    Route::get('generalization-trainings', [GeneralizationTrainingV2Controller::class, 'index']);
    Route::post('generalization-trainings', [GeneralizationTrainingV2Controller::class, 'store']);
    Route::get('generalization-trainings/{id}', [GeneralizationTrainingV2Controller::class, 'show']);
    Route::put('generalization-trainings/{id}', [GeneralizationTrainingV2Controller::class, 'update']);
    Route::delete('generalization-trainings/{id}', [GeneralizationTrainingV2Controller::class, 'destroy']);
});

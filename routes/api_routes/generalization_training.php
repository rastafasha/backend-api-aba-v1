<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Bip\GeneralizationTrainingController;

Route::get('generalizationtraining', [GeneralizationTrainingController::class, 'index'])->name('generalizationtraining.index');
Route::get('generalizationtraining/show/{id}', [GeneralizationTrainingController::class, 'show'])->name('generalizationtraining.show');
Route::get('generalizationtraining/profile/{id}', [GeneralizationTrainingController::class, 'showbyProfile'])->name('generalizationtraining.showbyProfile');
Route::get('generalizationtraining/showgbyPatientId/{patient_id}', [GeneralizationTrainingController::class, 'showgbyPatientId'])->name('showgbyPatientId');

Route::post('generalizationtraining/store', [GeneralizationTrainingController::class, 'store'])->name('generalizationtraining.store');
Route::post('generalizationtraining/update/{goal}', [GeneralizationTrainingController::class, 'update'])->name('generalizationtraining.update');
Route::delete('generalizationtraining/destroy/{id}', [GeneralizationTrainingController::class, 'destroy'])->name('generalizationtraining.destroy');

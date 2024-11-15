<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Bip\GeneralizationTrainingController;

Route::get('generalizationtraining', [GeneralizationTrainingController::class, 'index'])->name('index');
Route::get('generalizationtraining/show/{id}', [GeneralizationTrainingController::class, 'show'])->name('show');
Route::get('generalizationtraining/profile/{id}', [GeneralizationTrainingController::class, 'showbyProfile'])->name('showbyProfile');
Route::get('generalizationtraining/showgbyPatientId/{patient_id}', [GeneralizationTrainingController::class, 'showgbyPatientId'])->name('showgbyPatientId');

Route::post('generalizationtraining/store', [GeneralizationTrainingController::class, 'store'])->name('store');
Route::post('generalizationtraining/update/{goal}', [GeneralizationTrainingController::class, 'update'])->name('update');
Route::delete('generalizationtraining/destroy/{id}', [GeneralizationTrainingController::class, 'destroy'])->name('destroy');

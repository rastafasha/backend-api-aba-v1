<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Bip\MonitoringEvaluatingController;

Route::get('monitoringevaluating', [MonitoringEvaluatingController::class, 'index'])->name('monitoringevaluating.index');
Route::get('monitoringevaluating/show/{id}', [MonitoringEvaluatingController::class, 'show'])->name('monitoringevaluating.show');
Route::get('monitoringevaluating/profile/{id}', [MonitoringEvaluatingController::class, 'showbyProfile'])->name('monitoringevaluating.showbyProfile');
Route::get('monitoringevaluating/showgbyPatientId/{patient_id}', [MonitoringEvaluatingController::class, 'showgbyPatientId'])->name('monitoringevaluating.showgbyPatientId');

Route::post('monitoringevaluating/store', [MonitoringEvaluatingController::class, 'store'])->name('monitoringevaluating.store');
Route::post('monitoringevaluating/update/{goal}', [MonitoringEvaluatingController::class, 'update'])->name('monitoringevaluating.update');
Route::delete('monitoringevaluating/destroy/{id}', [MonitoringEvaluatingController::class, 'destroy'])->name('monitoringevaluating.destroy');

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Bip\MonitoringEvaluatingController;

Route::get('monitoringevaluating', [MonitoringEvaluatingController::class, 'index'])->name('index');
Route::get('monitoringevaluating/show/{id}', [MonitoringEvaluatingController::class, 'show'])->name('show');
Route::get('monitoringevaluating/profile/{id}', [MonitoringEvaluatingController::class, 'showbyProfile'])->name('showbyProfile');
Route::get('monitoringevaluating/showgbyPatientId/{patient_id}', [MonitoringEvaluatingController::class, 'showgbyPatientId'])->name('showgbyPatientId');

Route::post('monitoringevaluating/store', [MonitoringEvaluatingController::class, 'store'])->name('store');
Route::post('monitoringevaluating/update/{goal}', [MonitoringEvaluatingController::class, 'update'])->name('update');
Route::delete('monitoringevaluating/destroy/{id}', [MonitoringEvaluatingController::class, 'destroy'])->name('destroy');

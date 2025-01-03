<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Graphics\GraphicReductionController;

Route::get('graphic_reduction', [GraphicReductionController::class, 'index'])->name('graphic_reduction.index');
Route::get('graphic_reduction/show/{id}', [GraphicReductionController::class, 'show'])->name('graphic_reduction.show');
Route::get('graphic_reduction/config', [GraphicReductionController::class, 'config'])->name('graphic_reduction.config');
Route::get('graphic_reduction/showpatient/{patient_identifier}', [GraphicReductionController::class, 'showPatientId'])->name('graphic_reduction.showPatientId');
Route::get('graphic_reduction/showbyPatient/{patient_identifier}', [GraphicReductionController::class, 'showbyPatientId'])->name('graphic_reduction.showbyPatientId');
Route::get(
    'graphic_reduction/showbyMaladaptive/{maladaptive}/{patient_identifier}',
    [GraphicReductionController::class, 'showGragphicbyMaladaptive']
)->name('graphic_reduction.showGragphicbyMaladaptive');
Route::get(
    'graphic_reduction/showbyReplacement/{replacement}/{patient_identifier}',
    [GraphicReductionController::class, 'showGragphicbyReplacement']
)->name('graphic_reduction.showGragphicbyReplacement');
Route::post('graphic_reduction/patient-month', [GraphicReductionController::class, 'graphic_patient_month'])->name('graphic_reduction.graphic_patient_month');

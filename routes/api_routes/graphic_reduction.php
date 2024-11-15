<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Graphics\GraphicReductionController;

Route::get('graphic_reduction', [GraphicReductionController::class, 'index'])->name('index');
Route::get('graphic_reduction/show/{id}', [GraphicReductionController::class, 'show'])->name('show');
Route::get('graphic_reduction/config', [GraphicReductionController::class, 'config'])->name('config');
Route::get('graphic_reduction/showpatient/{patient_id}', [GraphicReductionController::class, 'showPatientId'])->name('showPatientId');
Route::get('graphic_reduction/showbyPatient/{patient_id}', [GraphicReductionController::class, 'showbyPatientId'])->name('showbyPatientId');
Route::get('graphic_reduction/showbyMaladaptive/{maladaptive}/{patient_id}', [GraphicReductionController::class, 'showGragphicbyMaladaptive'])->name('showGragphicbyMaladaptive');
Route::get('graphic_reduction/showbyReplacement/{replacement}/{patient_id}', [GraphicReductionController::class, 'showGragphicbyReplacement'])->name('showGragphicbyReplacement');
Route::post('graphic_reduction/patient-month', [GraphicReductionController::class, 'graphic_patient_month'])->name('graphic_patient_month');

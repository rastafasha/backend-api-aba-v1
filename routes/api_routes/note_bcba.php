<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Notes\NoteBcbaController;
use App\Http\Controllers\OpenAIController;

Route::get('note_bcba', [NoteBcbaController::class, 'index'])->name('index');
Route::get('note_bcba/config', [NoteBcbaController::class, 'config'])->name('config');
Route::get('note_bcba/show/{id}', [NoteBcbaController::class, 'show'])->name('show');
Route::get('note_bcba/byprofile/{patient_id}', [NoteBcbaController::class, 'showByPatientId'])->name('showByPatientId');
Route::get('note_bcba/byclient/{client_id}', [NoteBcbaController::class, 'showByClienttId'])->name('showByClienttId');


Route::get('/note_bcba/showReplacementBypatient/{id}', [NoteBcbaController::class, 'showReplacementsByPatient'] )->name('showReplacementsByPatient');
Route::get('/note_bcba/showNoteBypatient/{id}', [NoteBcbaController::class, 'showNoteBcbaByPatient'] )->name('showNoteBcbaByPatient');


Route::post('note_bcba/store', [NoteBcbaController::class, 'storebcba'])->name('storebcba');
Route::post('note_bcba/update/{id}', [NoteBcbaController::class, 'update'])->name('update');
Route::delete('note_bcba/destroy/{id}', [NoteBcbaController::class, 'destroy'])->name('destroy');

Route::put('/note_bcba/update/modifier/{note_bcba:id}', [NoteBcbaController::class, 'updateModifier'])
    ->name('note_bcba.updateModifier');

Route::put('/note_bcba/update/status/{note_bcba:id}', [NoteBcbaController::class, 'updateStatus'])
    ->name('note_bcba.updateStatus');

Route::post('/note_bcba/generate-summary', [OpenAIController::class, 'generateBcbaSummary'])
    ->name('note_bcba.generateSummary');

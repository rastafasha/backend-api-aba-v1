<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Notes\NoteRbtController;
use App\Http\Controllers\OpenAIController;

Route::get('note_rbt', [NoteRbtController::class, 'index'])->name('index');
Route::get('note_rbt/config', [NoteRbtController::class, 'config'])->name('config');
Route::get('note_rbt/show/{id}', [NoteRbtController::class, 'show'])->name('show');
Route::get('note_rbt/byprofile/{patient_id}', [NoteRbtController::class, 'showByPatientId'])->name('showByPatientId');
Route::get('note_rbt/byclient/{client_id}', [NoteRbtController::class, 'showByClienttId'])->name('showByClienttId');


Route::get('note_rbt/showReplacementBypatient/{id}', [NoteRbtController::class, 'showReplacementsByPatient'] )->name('showReplacementsByPatient');
Route::get('note_rbt/showNoteBypatient/{id}', [NoteRbtController::class, 'showNoteRbtByPatient'] )->name('showNoteRbtByPatient');

Route::get('note_rbt/showCptUnits/{patient_id}/{cpt_code}/{provider}/', [NoteRbtController::class, 'showCptUnits'] )->name('showCptUnits');

Route::post('note_rbt/store', [NoteRbtController::class, 'store'])->name('store');
Route::post('note_rbt/update/{id}', [NoteRbtController::class, 'update'])->name('update');
Route::delete('note_rbt/destroy/{id}', [NoteRbtController::class, 'destroy'])->name('destroy');


Route::post('note_rbt/storeReplacemts', [NoteRbtController::class, 'storeReplacemts'])->name('storeReplacemts');

Route::put('note_rbt/update/status/{note_rbt:id}', [NoteRbtController::class, 'updateStatus'])
    ->name('note_rbt.updateStatus');

Route::put('note_rbt/update/modifier/{note_rbt:id}', [NoteRbtController::class, 'updateModifier'])
    ->name('note_rbt.updateModifier');

Route::post("note_rbt/generate-summary", [OpenAIController::class, "generateSummary"])
    ->name("note_rbt.generateSummary");

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Notes\NoteRbtController;
use App\Http\Controllers\OpenAIController;

Route::get('note_rbt', [NoteRbtController::class, 'index'])->name('notes_rbt.index');
Route::get('note_rbt/config', [NoteRbtController::class, 'config'])->name('notes_rbt.config');
Route::get('note_rbt/show/{id}', [NoteRbtController::class, 'show'])->name('notes_rbt.show');
Route::get('note_rbt/byprofile/{patient_identifier}', [NoteRbtController::class, 'showByPatientId'])->name('notes_rbt.showByPatientId');
Route::get('note_rbt/byclient/{client_id}', [NoteRbtController::class, 'showByClienttId'])->name('notes_rbt.showByClienttId');


Route::get('note_rbt/showReplacementBypatient/{id}', [NoteRbtController::class, 'showReplacementsByPatient'])->name('notes_rbt.showReplacementsByPatient');
Route::get('note_rbt/showNoteBypatient/{id}', [NoteRbtController::class, 'showNoteRbtByPatient'])->name('notes_rbt.showNoteRbtByPatient');

Route::get('note_rbt/showCptUnits/{patient_identifier}/{cpt_code}/{provider}/', [NoteRbtController::class, 'showCptUnits'])->name('notes_rbt.showCptUnits');

Route::post('note_rbt/store', [NoteRbtController::class, 'store'])->name('notes_rbt.store');
Route::post('note_rbt/update/{id}', [NoteRbtController::class, 'update'])->name('notes_rbt.update');
Route::delete('note_rbt/destroy/{id}', [NoteRbtController::class, 'destroy'])->name('notes_rbt.destroy');


Route::post('note_rbt/storeReplacemts', [NoteRbtController::class, 'storeReplacemts'])->name('notes_rbt.storeReplacemts');

// Route::put('note_rbt/update-status/{note_rbt:id}', [NoteRbtController::class, 'updateStatus'])
//     ->name('note_rbt.updateStatus');


Route::post("note_rbt/generate-summary", [OpenAIController::class, "generateRbtSummary"])
    ->name("notes_rbt.generateSummary");

// V2 routes
Route::prefix('v2/notes')->group(function () {
    Route::get('/rbt', [App\Http\Controllers\Admin\Notes\NoteRbtV2Controller::class, 'index']);
    Route::get('/rbt/{id}', [App\Http\Controllers\Admin\Notes\NoteRbtV2Controller::class, 'show']);
    Route::post('/rbt', [App\Http\Controllers\Admin\Notes\NoteRbtV2Controller::class, 'store']);
    Route::put('/rbt/{id}', [App\Http\Controllers\Admin\Notes\NoteRbtV2Controller::class, 'update']);
    Route::put('/rbt/update-status/{id}', [NoteRbtController::class, 'updateStatus']);
    Route::patch('/rbt/{id}', [App\Http\Controllers\Admin\Notes\NoteRbtV2Controller::class, 'patch']);
    Route::delete('/rbt/{id}', [App\Http\Controllers\Admin\Notes\NoteRbtV2Controller::class, 'destroy']);
});

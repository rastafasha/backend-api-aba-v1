<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Notes\NoteRbtController;

Route::get('note_rbt', [NoteRbtController::class, 'index'])->name('index');
Route::get('note_rbt/config', [NoteRbtController::class, 'config'])->name('config');
Route::get('note_rbt/show/{id}', [NoteRbtController::class, 'show'])->name('show');
Route::get('note_rbt/byprofile/{patient_id}', [NoteRbtController::class, 'showByPatientId'])->name('showByPatientId');
Route::get('note_rbt/byclient/{client_id}', [NoteRbtController::class, 'showByClienttId'])->name('showByClienttId');


Route::get('/note_rbt/showReplacementBypatient/{id}', [NoteRbtController::class, 'showReplacementsByPatient'] )->name('showReplacementsByPatient');
Route::get('/note_rbt/showNoteBypatient/{id}', [NoteRbtController::class, 'showNoteRbtByPatient'] )->name('showNoteRbtByPatient');


Route::post('note_rbt/store', [NoteRbtController::class, 'store'])->name('store');
Route::post('note_rbt/update/{id}', [NoteRbtController::class, 'update'])->name('update');
Route::delete('note_rbt/destroy/{id}', [NoteRbtController::class, 'destroy'])->name('destroy');


Route::post('note_rbt/storeReplacemts', [NoteRbtController::class, 'storeReplacemts'])->name('storeReplacemts');

Route::put('/note_rbt/update/status/{note_rbt:id}', [NoteRbtController::class, 'updateStatus'])
<<<<<<< HEAD
    ->name('note_rbt.updateStatus');

Route::put('/note_rbt/update/modifier/{note_rbt:id}', [NoteRbtController::class, 'updateModifier'])
    ->name('note_rbt.updateModifier');
=======
    ->name('note_rbt.updateStatus');
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

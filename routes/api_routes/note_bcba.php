<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Notes\NoteBcbaController;
use App\Http\Controllers\Admin\Notes\NoteBcbaV2Controller;
use App\Http\Controllers\OpenAIController;

Route::get('note_bcba', [NoteBcbaController::class, 'index'])->name('note_bcba.index');
Route::get('note_bcba/config', [NoteBcbaController::class, 'config'])->name('note_bcba.config');
Route::get('note_bcba/show/{id}', [NoteBcbaController::class, 'show'])->name('note_bcba.show');
Route::get('note_bcba/byprofile/{patient_identifier}', [NoteBcbaController::class, 'showByPatientId'])->name('note_bcba.showByPatientId');
Route::get('note_bcba/byclient/{client_id}', [NoteBcbaController::class, 'showByClienttId'])->name('note_bcba.showByClienttId');


Route::get('/note_bcba/showReplacementBypatient/{id}', [NoteBcbaController::class, 'showReplacementsByPatient'])->name('note_bcba.showReplacementsByPatient');
Route::get('/note_bcba/showNoteBypatient/{id}', [NoteBcbaController::class, 'showNoteBcbaByPatient'])->name('note_bcba.showNoteBcbaByPatient');


Route::post('note_bcba/store', [NoteBcbaController::class, 'storebcba'])->name('note_bcba.storebcba');
Route::post('note_bcba/update/{id}', [NoteBcbaController::class, 'update'])->name('note_bcba.update');
    Route::delete('note_bcba/destroy/{id}', [NoteBcbaController::class, 'destroy'])->name('note_bcba.destroy');

// Route::put('/note_bcba/update-status/{note_bcba:id}', [NoteBcbaController::class, 'updateStatus'])
//     ->name('note_bcba.updateStatus');

Route::post('/note_bcba/generate-summary', [OpenAIController::class, 'generateBcbaSummary'])
    ->name('note_bcba.generateSummary');


// V2 routes
Route::prefix('v2/notes')->group(function () {
    Route::get('/bcba', [NoteBcbaV2Controller::class, 'index']);
    Route::get('/bcba/{id}', [NoteBcbaV2Controller::class, 'show']);
    Route::post('/bcba', [NoteBcbaV2Controller::class, 'store']);
    Route::put('/bcba/{id}', [NoteBcbaV2Controller::class, 'update']);
    Route::patch('/bcba/{id}', [NoteBcbaV2Controller::class, 'patch']);
    Route::put('/bcba/update-status/{id}', [NoteBcbaController::class, 'updateStatus']);
    Route::delete('/bcba/{id}', [NoteBcbaV2Controller::class, 'destroy']);
});

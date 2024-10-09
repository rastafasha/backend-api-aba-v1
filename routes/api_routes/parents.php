<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParentController;

//Admin Usuarios
Route::get('/parents', [ParentController::class, 'index'])
    ->name('parents.index');

Route::get('/parent/show/{parent}', [ParentController::class, 'show'])
    ->name('parents.show');

Route::get('/parent/show-withpatient/{parent}/{patient_id}', [ParentController::class, 'showWithPatient'])
    ->name('parents.showWithPatient');

Route::get('/parent/show-withpatientbip/{parent}/{patient_id}', [ParentController::class, 'showWithPatientBip'])
    ->name('parents.showWithPatientBip');

Route::get('/parent/show-withpatient-rbtnote/{parent}/{patient_id}', [ParentController::class, 'showWithPatientRBTNotes'])
    ->name('parents.showWithPatientRBTNotes');

Route::get('/parent/show-withpatient-rbtnote-recent/{parent}/{patient_id}', [ParentController::class, 'showWithPatientRBTNotesRecents'])
    ->name('parents.showWithPatientRBTNotesRecents');

Route::get('/parent/show-withpatient-bcbanote/{parent}/{patient_id}', [ParentController::class, 'showWithPatientBCBANotes'])
    ->name('parents.showWithPatientBCBANotes');

Route::get('/parent/show-withpatient-bcbanote-recent/{parent}/{patient_id}', [ParentController::class, 'showWithPatientBCBANotesRecent'])
    ->name('parents.showWithPatientBCBANotesRecent');


Route::post('/parent/update/{id}', [ParentController::class, 'update'])
    ->name('parents.update');
    
Route::post('parents/store', [ParentController::class, 'store'])->name('store');

Route::delete('/parent/destroy/{parent}', [ParentController::class, 'destroy'])
    ->name('parents.destroy');

Route::get('parent/recientes/', [ParentController::class, 'recientes'])
    ->name('parents.recientes');

Route::get('parent/search/{request}', [ParentController::class, 'search'])
    ->name('parents.search');





<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Bip\SustitutionGoalController;

Route::get('sustitutiongoal', [SustitutionGoalController::class, 'index'])->name('sustitutiongoal.index');
Route::get('sustitutiongoal/profile/{id}', [SustitutionGoalController::class, 'showbyProfile'])->name('sustitutiongoal.showbyProfile');
Route::get('sustitutiongoal/config', [SustitutionGoalController::class, 'config'])->name('sustitutiongoal.config');
Route::post('sustitutiongoal/store', [SustitutionGoalController::class, 'store'])->name('sustitutiongoal.store');
Route::get('sustitutiongoal/show/{id}', [SustitutionGoalController::class, 'show'])->name('sustitutiongoal.show');


Route::get('sustitutiongoal/show/goalsmaladaptives/{maladaptive}', [SustitutionGoalController::class, 'showGoalsbyMaladaptive'])
    ->name('sustitutiongoal.showGoalsbyMaladaptive2');

Route::get('sustitutiongoal/showbyGoal/{goal}', [SustitutionGoalController::class, 'showGoalsbyMaladaptive'])->name('sustitutiongoal.showGoalsbyMaladaptive3');
Route::get('sustitutiongoal/showBipId/{bip_id}', [SustitutionGoalController::class, 'showGoalsbBipId'])->name('sustitutiongoal.showGoalsbBipId');
Route::get('sustitutiongoal/showgbyPatientId/{patient_identifier}', [SustitutionGoalController::class, 'showgbyPatientId'])->name('sustitutiongoal.showgbyPatientId');

Route::get('sustitutiongoal/showStogbyGoal/{goal}', [SustitutionGoalController::class, 'showgbyPatientIdFilterGoal'])->name('sustitutiongoal.showgbyPatientIdFilterGoal');
Route::get('sustitutiongoal/showStogbyGoalPatient/{patient_identifier}', [
    SustitutionGoalController::class,
    'showgbyPatientIdFilterGoalStoInprogress'
])->name('sustitutiongoal.showgbyPatientIdFilterGoalStoInprogress');

Route::post('sustitutiongoal/update/{goal}', [SustitutionGoalController::class, 'update'])->name('sustitutiongoal.update');
Route::delete('sustitutiongoal/destroy/{id}', [SustitutionGoalController::class, 'destroy'])->name('sustitutiongoal.destroy');
Route::put('/sustitutiongoal/update/sto/{goal:id}', [SustitutionGoalController::class, 'updateSto'])
    ->name('sustitutiongoal.updateSto');

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Bip\SustitutionGoalController;

Route::get('sustitutiongoal', [SustitutionGoalController::class, 'index'])->name('index');
Route::get('sustitutiongoal/profile/{id}', [SustitutionGoalController::class, 'showbyProfile'])->name('showbyProfile');
Route::get('sustitutiongoal/config', [SustitutionGoalController::class, 'config'])->name('config');
Route::post('sustitutiongoal/store', [SustitutionGoalController::class, 'store'])->name('store');
Route::get('sustitutiongoal/show/{id}', [SustitutionGoalController::class, 'show'])->name('show');


Route::get('sustitutiongoal/show/goalsmaladaptives/{maladaptive}', [SustitutionGoalController::class, 'showGoalsbyMaladaptive'])->name('showGoalsbyMaladaptive');

Route::get('sustitutiongoal/showbyGoal/{goal}', [SustitutionGoalController::class, 'showGoalsbyMaladaptive'])->name('showGoalsbyMaladaptive');
Route::get('sustitutiongoal/showBipId/{bip_id}', [SustitutionGoalController::class, 'showGoalsbBipId'])->name('showGoalsbBipId');
Route::get('sustitutiongoal/showgbyPatientId/{patient_id}', [SustitutionGoalController::class, 'showgbyPatientId'])->name('showgbyPatientId');

Route::get('sustitutiongoal/showStogbyGoal/{goal}', [SustitutionGoalController::class, 'showgbyPatientIdFilterGoal'])->name('showgbyPatientIdFilterGoal');
Route::get('sustitutiongoal/showStogbyGoalPatient/{patient_id}', [SustitutionGoalController::class, 'showgbyPatientIdFilterGoalStoInprogress'])->name('showgbyPatientIdFilterGoalStoInprogress');

Route::post('sustitutiongoal/update/{goal}', [SustitutionGoalController::class, 'update'])->name('update');
Route::delete('sustitutiongoal/destroy/{id}', [SustitutionGoalController::class, 'destroy'])->name('destroy');
Route::put('/sustitutiongoal/update/sto/{goal:id}', [SustitutionGoalController::class, 'updateSto'])
    ->name('sustitutiongoal.updateSto');

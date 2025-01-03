<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Bip\FamilyEnvolmentGoalController;

Route::get('familyenvolvment', [FamilyEnvolmentGoalController::class, 'index'])->name('family_envolments.index');
Route::get('familyenvolvment/show/{id}', [FamilyEnvolmentGoalController::class, 'show'])->name('family_envolments.show');
Route::get('familyenvolvment/profile/{id}', [FamilyEnvolmentGoalController::class, 'showbyProfile'])->name('family_envolments.showbyProfile');
Route::get('familyenvolvment/showgbyPatientId/{patient_id}', [FamilyEnvolmentGoalController::class, 'showgbyPatientId'])->name('showgbyPatientId');

Route::post('familyenvolvment/store', [FamilyEnvolmentGoalController::class, 'store'])->name('family_envolments.store');
Route::post('familyenvolvment/update/{goal}', [FamilyEnvolmentGoalController::class, 'update'])->name('family_envolments.update');
Route::delete('familyenvolvment/destroy/{id}', [FamilyEnvolmentGoalController::class, 'destroy'])->name('family_envolments.destroy');

// Route::get('familyenvolvment/show/goalsmaladaptives/{maladaptive}', [FamilyEnvolmentGoalController::class, 'showGoalsbyMaladaptive'])->name('showGoalsbyMaladaptive');

// Route::get('familyenvolvment/showbyGoal/{goal}', [FamilyEnvolmentGoalController::class, 'showGoalsbyMaladaptive'])->name('showGoalsbyMaladaptive');
// Route::get('familyenvolvment/showBipId/{bip_id}', [FamilyEnvolmentGoalController::class, 'showGoalsbBipId'])->name('showGoalsbBipId');

// Route::put('/familyenvolvment/update/sto/{goal:id}', [FamilyEnvolmentGoalController::class, 'updateSto'])
//     ->name('familyenvolvment.updateSto');

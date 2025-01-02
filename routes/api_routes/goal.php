<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Bip\ReductionGoalController;
use App\Http\Controllers\Admin\Bip\LongTermObjectiveV2Controller;
use App\Http\Controllers\Admin\Bip\ShortTermObjectiveV2Controller;
use App\Http\Controllers\Admin\Bip\ReductionGoalV2Controller;
use App\Http\Controllers\Admin\Bip\MaladaptiveV2Controller;

Route::get('goal', [ReductionGoalController::class, 'index'])->name('index');
Route::get('goal/profile/{id}', [ReductionGoalController::class, 'showbyProfile'])->name('showbyProfile');
Route::get('goal/config', [ReductionGoalController::class, 'config'])->name('config');
Route::post('goal/store', [ReductionGoalController::class, 'store'])->name('store');
Route::get('goal/show/{id}', [ReductionGoalController::class, 'show'])->name('show');

// /{patient_id}
Route::get('goal/show/goalsmaladaptives/{maladaptive}/{patient_identifier}', [ReductionGoalController::class, 'showGoalsbyMaladaptive'])->name('showGoalsbyMaladaptive');

Route::get('goal/showbyGoal/{goal}', [ReductionGoalController::class, 'showGoalsbyMaladaptive'])->name('showGoalsbyMaladaptive');
Route::get('goal/showBipId/{bip_id}', [ReductionGoalController::class, 'showGoalsbBipId'])->name('showGoalsbBipId');
Route::get('goal/showgbyPatientId/{patient_identifier}', [ReductionGoalController::class, 'showgbyPatientId'])->name('showgbyPatientId');



Route::post('goal/update/{goal}', [ReductionGoalController::class, 'update'])->name('update');
Route::delete('goal/destroy/{id}', [ReductionGoalController::class, 'destroy'])->name('destroy');

Route::put('/goal/update/eligibility/{bip:id}', [ReductionGoalController::class, 'updateEligibility'])
    ->name('goal.updateEligibility');
Route::put('/goal/update/sto/{goal:id}', [ReductionGoalController::class, 'updateSto'])
    ->name('goal.updateSto');

Route::prefix('v2')->group(function () {
    Route::apiResource('reduction-goals', ReductionGoalV2Controller::class);
    Route::apiResource('maladaptives', MaladaptiveV2Controller::class);
    Route::apiResource('long-term-objectives', LongTermObjectiveV2Controller::class);
    Route::apiResource('short-term-objectives', ShortTermObjectiveV2Controller::class);
    Route::post('short-term-objectives/reorder', [ShortTermObjectiveV2Controller::class, 'reorder']);
});

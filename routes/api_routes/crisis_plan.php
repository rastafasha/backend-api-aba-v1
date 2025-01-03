<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Bip\CrisisPlanController;

Route::get('crisisplan', [CrisisPlanController::class, 'index'])->name('crisis_plans.index');
Route::get('crisisplan/show/{id}', [CrisisPlanController::class, 'show'])->name('crisis_plans.show');
Route::get('crisisplan/profile/{patient_id}', [CrisisPlanController::class, 'showbyProfile'])->name('crisis_plans.showbyProfile');
Route::get('crisisplan/showgbyPatientId/{patient_id}', [CrisisPlanController::class, 'showgbyPatientId'])->name('showgbyPatientId');

Route::post('crisisplan/store', [CrisisPlanController::class, 'store'])->name('crisis_plans.store');
Route::post('crisisplan/update/{goal}', [CrisisPlanController::class, 'update'])->name('crisis_plans.update');
Route::delete('crisisplan/destroy/{id}', [CrisisPlanController::class, 'destroy'])->name('crisis_plans.destroy');

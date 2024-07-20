<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Bip\CrisisPlanController;

Route::get('crisisplan', [CrisisPlanController::class, 'index'])->name('index');
Route::get('crisisplan/show/{id}', [CrisisPlanController::class, 'show'])->name('show');
Route::get('crisisplan/profile/{id}', [CrisisPlanController::class, 'showbyProfile'])->name('showbyProfile');
Route::get('crisisplan/showgbyPatientId/{patient_id}', [CrisisPlanController::class, 'showgbyPatientId'])->name('showgbyPatientId');

Route::post('crisisplan/store', [CrisisPlanController::class, 'store'])->name('store');
Route::post('crisisplan/update/{goal}', [CrisisPlanController::class, 'update'])->name('update');
Route::delete('crisisplan/destroy/{id}', [CrisisPlanController::class, 'destroy'])->name('destroy');


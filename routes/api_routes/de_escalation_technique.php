<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Bip\DeEscalationTechniqueController;

Route::get('deescalationtechnique', [DeEscalationTechniqueController::class, 'index'])->name('index');
Route::get('deescalationtechnique/show/{id}', [DeEscalationTechniqueController::class, 'show'])->name('show');
Route::get('deescalationtechnique/profile/{id}', [DeEscalationTechniqueController::class, 'showbyProfile'])->name('showbyProfile');
Route::get('deescalationtechnique/showgbyPatientId/{patient_id}', [DeEscalationTechniqueController::class, 'showgbyPatientId'])->name('showgbyPatientId');

Route::post('deescalationtechnique/store', [DeEscalationTechniqueController::class, 'store'])->name('store');
Route::post('deescalationtechnique/update/{goal}', [DeEscalationTechniqueController::class, 'update'])->name('update');
Route::delete('deescalationtechnique/destroy/{id}', [DeEscalationTechniqueController::class, 'destroy'])->name('destroy');


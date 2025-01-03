<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Bip\DeEscalationTechniqueController;

Route::get('deescalationtechnique', [DeEscalationTechniqueController::class, 'index'])->name('de_escalation_techniques.index');
Route::get('deescalationtechnique/show/{id}', [DeEscalationTechniqueController::class, 'show'])->name('de_escalation_techniques.show');
Route::get('deescalationtechnique/profile/{id}', [DeEscalationTechniqueController::class, 'showbyProfile'])->name('de_escalation_techniques.showbyProfile');
Route::get('deescalationtechnique/showgbyPatientId/{patient_id}', [DeEscalationTechniqueController::class, 'showgbyPatientId'])->name('showgbyPatientId');

Route::post('deescalationtechnique/store', [DeEscalationTechniqueController::class, 'store'])->name('de_escalation_techniques.store');
Route::post('deescalationtechnique/update/{goal}', [DeEscalationTechniqueController::class, 'update'])->name('de_escalation_techniques.update');
Route::delete('deescalationtechnique/destroy/{id}', [DeEscalationTechniqueController::class, 'destroy'])->name('de_escalation_techniques.destroy');

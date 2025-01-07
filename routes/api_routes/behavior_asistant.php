<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Bip\BehviorAsistantController;

Route::get('behaviorasistant', [BehviorAsistantController::class, 'index'])->name('behavior_asistants.index');
Route::get('behaviorasistant/show/{id}', [BehviorAsistantController::class, 'show'])->name('behavior_asistants.show');
Route::get('behaviorasistant/profile/{id}', [BehviorAsistantController::class, 'showbyProfile'])->name('behavior_asistants.showbyProfile');
Route::get('behaviorasistant/showgbyPatientId/{patient_id}', [BehviorAsistantController::class, 'showgbyPatientId'])->name('behavior_asistants.showgbyPatientId');

Route::post('behaviorasistant/store', [BehviorAsistantController::class, 'store'])->name('behavior_asistants.store');
Route::post('behaviorasistant/update/{goal}', [BehviorAsistantController::class, 'update'])->name('behavior_asistants.update');
Route::delete('behaviorasistant/destroy/{id}', [BehviorAsistantController::class, 'destroy'])->name('behavior_asistants.destroy');

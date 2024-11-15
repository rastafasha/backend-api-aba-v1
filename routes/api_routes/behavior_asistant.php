<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Bip\BehviorAsistantController;

Route::get('behaviorasistant', [BehviorAsistantController::class, 'index'])->name('index');
Route::get('behaviorasistant/show/{id}', [BehviorAsistantController::class, 'show'])->name('show');
Route::get('behaviorasistant/profile/{id}', [BehviorAsistantController::class, 'showbyProfile'])->name('showbyProfile');
Route::get('behaviorasistant/showgbyPatientId/{patient_id}', [BehviorAsistantController::class, 'showgbyPatientId'])->name('showgbyPatientId');

Route::post('behaviorasistant/store', [BehviorAsistantController::class, 'store'])->name('store');
Route::post('behaviorasistant/update/{goal}', [BehviorAsistantController::class, 'update'])->name('update');
Route::delete('behaviorasistant/destroy/{id}', [BehviorAsistantController::class, 'destroy'])->name('destroy');

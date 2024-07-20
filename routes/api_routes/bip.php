<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Bip\BipController;

Route::get('bip', [BipController::class, 'index'])->name('index');
Route::get('bip/show/{id}', [BipController::class, 'show'])->name('show');
Route::get('bip/config', [BipController::class, 'config'])->name('config');
Route::get('bip/profile/{patient_id}', [BipController::class, 'showProfile'])->name('showProfile');
Route::get('bip/profileBip/{patient_id}', [BipController::class, 'showBipPatientIdProfile'])->name('showBipPatientIdProfile');
Route::get('bip/profileBipPdf/{patient_id}', [BipController::class, 'showBipPatientIdProfilePdf'])->name('showBipPatientIdProfile');
Route::post('bip/store', [BipController::class, 'store'])->name('store');
Route::put('bip/update/{id}', [BipController::class, 'update'])->name('update');

Route::get('bip/show/byuser/{patient_id}', [BipController::class, 'showbyUser'])->name('showbyUser');
Route::get('bip/show/byuserpatientid/{patient_id}', [BipController::class, 'showbyUserPatientId'])->name('showbyUserPatientId');
Route::delete('bip/destroy/{id}', [BipController::class, 'destroy'])->name('destroy');



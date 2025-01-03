<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Bip\BipController;
use App\Http\Controllers\Admin\Bip\BipV2Controller;

Route::get('bip', [BipController::class, 'index'])->name('bip.index');
Route::get('bip/show/{id}', [BipController::class, 'show'])->name('bip.show');
Route::get('bip/config', [BipController::class, 'config'])->name('bip.config');
Route::get('bip/profile/{patient_identifier}', [BipController::class, 'showProfile'])->name('bip.showProfile');
Route::get('bip/profileBip/{patient_identifier}', [BipController::class, 'showBipPatientIdProfile'])->name('bip.showBipPatientIdProfile');
Route::get('bip/profileBipPdf/{patient_identifier}', [BipController::class, 'showBipPatientIdProfilePdf'])->name('bip.showBipPatientIdProfilePdf');
Route::post('bip/store', [BipController::class, 'store'])->name('bip.store');
Route::put('bip/update/{id}', [BipController::class, 'update'])->name('bip.update');

Route::get('bip/show/byuser/{patient_identifier}', [BipController::class, 'showbyUser'])->name('bip.showbyUser');
Route::get('bip/show/byuserpatientid/{patient_id}', [BipController::class, 'showbyUserPatientId'])->name('bip.showbyUserPatientId');
Route::delete('bip/destroy/{id}', [BipController::class, 'destroy'])->name('bip.destroy');

Route::prefix('v2/bips')->group(function () {
    Route::get('/', [BipV2Controller::class, 'index'])->name('bip.v2.index');
    Route::post('/', [BipV2Controller::class, 'store'])->name('bip.v2.store');
    Route::get('/{id}', [BipV2Controller::class, 'show'])->name('bip.v2.show');
    Route::put('/{id}', [BipV2Controller::class, 'update'])->name('bip.v2.update');
    Route::delete('/{id}', [BipV2Controller::class, 'destroy'])->name('bip.v2.destroy');
});

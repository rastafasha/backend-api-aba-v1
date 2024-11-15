<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Doctor\DoctorController;

Route::get('doctors', [DoctorController::class, 'indexDoctor'])->name('indexDoctor');
Route::get('doctors/config', [DoctorController::class, 'configDoctor'])->name('configDoctor');
Route::get('doctors/configlocation/{location_id}', [DoctorController::class, 'configDoctorLocation'])->name('configDoctorLocation');

Route::post('doctors/store', [DoctorController::class, 'storeDoctor'])->name('storeDoctor');

Route::get('doctors/check-email-exist/{email}', [DoctorController::class, 'emailExist'])->name('emailExist');

Route::get('doctors/show/{id}', [DoctorController::class, 'showDoctor'])->name('showDoctor');
Route::post('doctors/update/{id}', [DoctorController::class, 'updateDoctor'])->name('updateDoctor');
Route::delete('doctors/destroy/{id}', [DoctorController::class, 'destroyDoctor'])->name('destroyDoctor');
Route::put('/doctors/update/status/{id}', [DoctorController::class, 'updateStatus'])
    ->name('doctors.updateStatus');
Route::get('doctors/profile/{id}', [DoctorController::class, 'profileDoctor'])->name('profileDoctor');

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Doctor\DoctorController;

Route::get('doctors', [DoctorController::class, 'indexDoctor'])->name('doctors.indexDoctor');
Route::get('doctors/config', [DoctorController::class, 'configDoctor'])->name('doctors.configDoctor');
Route::get('doctors/configlocation/{location_id}', [DoctorController::class, 'configDoctorLocation'])->name('doctors.configDoctorLocation');

Route::post('doctors/store', [DoctorController::class, 'storeDoctor'])->name('doctors.storeDoctor');

Route::get('doctors/check-email-exist/{email}', [DoctorController::class, 'emailExist'])->name('doctors.emailExist');

Route::get('doctors/show/{id}', [DoctorController::class, 'showDoctor'])->name('doctors.showDoctor');
Route::post('doctors/update/{id}', [DoctorController::class, 'updateDoctor'])->name('doctors.updateDoctor');
Route::delete('doctors/destroy/{id}', [DoctorController::class, 'destroyDoctor'])->name('doctors.destroyDoctor');
Route::put('/doctors/update/status/{id}', [DoctorController::class, 'updateStatus'])
    ->name('doctors.updateStatus');
Route::get('doctors/profile/{id}', [DoctorController::class, 'profileDoctor'])->name('doctors.profileDoctor');

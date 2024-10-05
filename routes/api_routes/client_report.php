<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Billing\ClientReportController;

Route::get('client_report/', [ClientReportController::class, 'index'])->name('index');
Route::get('client_report/filter', [ClientReportController::class, 'filter'])->name('filter');
Route::get('client_report/config', [ClientReportController::class, 'config'])->name('config');
Route::get('client_report/show/{id}', [ClientReportController::class, 'show'])->name('show');
Route::get('client_report/byprofile/{patient_id}', [ClientReportController::class, 'showByPatientId'])->name('showByPatientId');
Route::get('client_report/bylocation/{location_id}', [ClientReportController::class, 'showByLocationId'])->name('showByLocationId');

Route::get('client_report/byemployee/{doctor_id}/{patient_id}', [ClientReportController::class, 'showByPatientByDoctorId'])->name('showByPatientByDoctorId');

Route::get('client_report/showCptUnits/{patient_id}/{cpt_code}/{provider}/', [ClientReportController::class, 'showCptUnits'] )->name('showCptUnits');


Route::post('client_report/store', [ClientReportController::class, 'store'])->name('store');
Route::post('client_report/update/{id}', [ClientReportController::class, 'update'])->name('update');
Route::delete('client_report/destroy/{id}', [ClientReportController::class, 'destroy'])->name('destroy');

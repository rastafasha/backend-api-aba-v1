<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Billing\ClientReportController;

Route::get('client_report/', [ClientReportController::class, 'index'])->name('client_reports.index');
Route::get('client_report/filter', [ClientReportController::class, 'filter'])->name('client_reports.filter');
Route::get('client_report/config', [ClientReportController::class, 'config'])->name('client_reports.config');
Route::get('client_report/show/{id}', [ClientReportController::class, 'show'])->name('client_reports.show');
Route::get('client_report/byprofile/{patient_identifier}', [ClientReportController::class, 'showByPatientId'])->name('client_reports.showByPatientId');
Route::get('client_report/bylocation/{location_id}', [ClientReportController::class, 'showByLocationId'])->name('client_reports.showByLocationId');

Route::get('client_report/byemployee/{doctor_id}/{patient_identifier}', [ClientReportController::class, 'showByPatientByDoctorId'])->name('client_reports.showByPatientByDoctorId');

Route::get('client_report/showCptUnits/{patient_identifier}/{cpt_code}/{provider}/', [ClientReportController::class, 'showCptUnits'])->name('client_reports.showCptUnits');


Route::post('client_report/store', [ClientReportController::class, 'store'])->name('client_reports.store');
Route::post('client_report/update/{id}', [ClientReportController::class, 'update'])->name('client_reports.update');
Route::delete('client_report/destroy/{id}', [ClientReportController::class, 'destroy'])->name('client_reports.destroy');

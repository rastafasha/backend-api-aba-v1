<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Billing\BillingController;

Route::get('billing', [BillingController::class, 'index'])->name('index');
Route::get('billing/config', [BillingController::class, 'config'])->name('config');
Route::get('billing/show/{id}', [BillingController::class, 'show'])->name('show');
Route::get('billing/byprofile/{patient_id}', [BillingController::class, 'showByPatientId'])->name('showByPatientId');
Route::get('billing/profile/{id}', [BillingController::class, 'showProfile'])->name('showProfile');

Route::post('billing/store', [BillingController::class, 'store'])->name('store');
Route::post('billing/update/{id}', [BillingController::class, 'update'])->name('update');
Route::delete('billing/destroy/{id}', [BillingController::class, 'destroy'])->name('destroy');

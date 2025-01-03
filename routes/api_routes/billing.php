<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Billing\BillingController;

Route::get('billing', [BillingController::class, 'index'])->name('billing.index');
Route::get('billing/config', [BillingController::class, 'config'])->name('billing.config');
Route::get('billing/show/{id}', [BillingController::class, 'show'])->name('billing.show');
Route::get('billing/byprofile/{patient_id}', [BillingController::class, 'showByPatientId'])->name('billing.showByPatientId');
Route::get('billing/profile/{id}', [BillingController::class, 'showProfile'])->name('billing.showProfile');

Route::post('billing/store', [BillingController::class, 'store'])->name('billing.store');
Route::post('billing/update/{id}', [BillingController::class, 'update'])->name('billing.update');
Route::delete('billing/destroy/{id}', [BillingController::class, 'destroy'])->name('billing.destroy');

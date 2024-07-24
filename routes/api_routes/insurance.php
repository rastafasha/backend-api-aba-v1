<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\InsuranceController;

Route::resource('insurance', InsuranceController::class);

Route::post('/insurance/store', [InsuranceController::class, 'store'])
    ->name('insurance.store');
    
Route::get('/insurance/show/{insurance}', [InsuranceController::class, 'show'])
    ->name('insurance.show');

Route::get('insurance/showInsuranceCpt/{insurer_name}/{code}/{provider}', [InsuranceController::class, 'showInsuranceCpt'])
    ->name('showInsuranceCpt');
    
Route::put('/insurance/update/{id}', [InsuranceController::class, 'update'])
    ->name('insurance.update');
    
Route::delete('/insurance/destroy/{insurance:id}', [InsuranceController::class, 'destroy'])
    ->name('insurance.destroy');
 
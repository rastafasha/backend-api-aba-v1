<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\InsuranceController;
use App\Http\Controllers\Admin\InsuranceV2Controller;

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
 
Route::prefix('v2/insurance')->group(function () {
    Route::get('/', [InsuranceV2Controller::class, 'index']);
    Route::post('/', [InsuranceV2Controller::class, 'store']);
    Route::get('/{id}', [InsuranceV2Controller::class, 'show']);
    Route::put('/{id}', [InsuranceV2Controller::class, 'update']);
    Route::delete('/{id}', [InsuranceV2Controller::class, 'destroy']);
});

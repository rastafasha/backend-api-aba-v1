<?php

use App\Http\Controllers\Admin\PaServiceController;
use App\Http\Controllers\Admin\PaServiceV2Controller;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'admin'], function () {
    // PA Services routes
    // I should move the requests here when the auth is done
    // TODO: Implement security
});

Route::get('patients/{patient_identfifier}/pa-services', [PaServiceController::class, 'index']);
Route::post('patients/{patient_identfifier}/pa-services', [PaServiceController::class, 'store']);
Route::get('patients/{patient_identfifier}/pa-services/{id}', [PaServiceController::class, 'show']);
Route::put('patients/{patient_identfifier}/pa-services/{id}', [PaServiceController::class, 'update']);
Route::delete('patients/{patient_identfifier}/pa-services/{id}', [PaServiceController::class, 'destroy']);

// V2 routes
Route::prefix('v2/patients/{patient_identfifier}/pa-services')->group(function () {
    Route::get('/', [PaServiceV2Controller::class, 'index']);
    Route::post('/', [PaServiceV2Controller::class, 'store']);
    Route::get('/{id}', [PaServiceV2Controller::class, 'show']);
    Route::put('/{id}', [PaServiceV2Controller::class, 'update']);
    Route::delete('/{id}', [PaServiceV2Controller::class, 'destroy']);
});

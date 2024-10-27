<?php

use App\Http\Controllers\Admin\PaServiceController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'admin'], function () {
    // PA Services routes
    // I should move the requests here when the auth is done
    // TODO: Implement security
});

    Route::get('patients/{patient_id}/pa-services', [PaServiceController::class, 'index']);
    Route::post('patients/{patient_id}/pa-services', [PaServiceController::class, 'store']);
    Route::get('patients/{patient_id}/pa-services/{id}', [PaServiceController::class, 'show']);
    Route::put('patients/{patient_id}/pa-services/{id}', [PaServiceController::class, 'update']);
    Route::delete('patients/{patient_id}/pa-services/{id}', [PaServiceController::class, 'destroy']);

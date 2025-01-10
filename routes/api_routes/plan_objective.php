<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Bip\PlanV2Controller;
use App\Http\Controllers\Admin\Bip\ObjectiveV2Controller;

Route::prefix('v2')->group(function () {
    // Plan routes
    Route::prefix('plans')->group(function () {
        Route::get('/', [PlanV2Controller::class, 'index']);
        Route::post('/', [PlanV2Controller::class, 'store']);
        Route::get('/{id}', [PlanV2Controller::class, 'show']);
        Route::put('/{id}', [PlanV2Controller::class, 'update']);
        Route::delete('/{id}', [PlanV2Controller::class, 'destroy']);
    });

    // Objective routes
    Route::prefix('objectives')->group(function () {
        Route::get('/', [ObjectiveV2Controller::class, 'index']);
        Route::post('/', [ObjectiveV2Controller::class, 'store']);
        Route::get('/{id}', [ObjectiveV2Controller::class, 'show']);
        Route::put('/{id}', [ObjectiveV2Controller::class, 'update']);
        Route::delete('/{id}', [ObjectiveV2Controller::class, 'destroy']);
        Route::post('/reorder', [ObjectiveV2Controller::class, 'reorder']);
    });
});

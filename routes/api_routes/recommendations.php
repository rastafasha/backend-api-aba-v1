<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Bip\RecommendationV2Controller;

// V2 Routes
Route::prefix('v2')->group(function () {
    Route::get('recommendations', [RecommendationV2Controller::class, 'index']);
    Route::post('recommendations', [RecommendationV2Controller::class, 'store']);
    Route::get('recommendations/{id}', [RecommendationV2Controller::class, 'show']);
    Route::put('recommendations/{id}', [RecommendationV2Controller::class, 'update']);
    Route::delete('recommendations/{id}', [RecommendationV2Controller::class, 'destroy']);
});

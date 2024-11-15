<?php

use App\Http\Controllers\Claims\ClaimsController;
use Illuminate\Support\Facades\Route;


Route::prefix('v2/claims')->group(function () {
    Route::get('/', [ClaimsController::class, 'index']);
    Route::post('/', [ClaimsController::class, 'store']);
    Route::get('/{id}', [ClaimsController::class, 'show']);
    Route::put('/{id}', [ClaimsController::class, 'update']);
    Route::delete('/{id}', [ClaimsController::class, 'destroy']);
    Route::post('/{id}/send-to-claim-md', [ClaimsController::class, 'sendToClaimMd']);
});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Bip\ShortTermObjectiveV2Controller;
use App\Http\Controllers\Admin\Bip\LongTermObjectiveV2Controller;
use App\Http\Controllers\Admin\Bip\MaladaptiveV2Controller;
use App\Http\Controllers\Admin\Bip\ReplacementV2Controller;

Route::prefix('v2')->group(
    function () {
        Route::apiResource('/short-term-objectives', ShortTermObjectiveV2Controller::class);
        Route::apiResource('/long-term-objectives', LongTermObjectiveV2Controller::class);
        Route::apiResource('/maladaptives', MaladaptiveV2Controller::class);
        Route::apiResource('/replacements', ReplacementV2Controller::class);
    }
);

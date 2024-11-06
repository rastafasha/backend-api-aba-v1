<?php

use App\Http\Controllers\Claims\ClaimsController;
use Illuminate\Support\Facades\Route;

Route::post('claims/generate-from-notes', [ClaimsController::class, 'generateFromNotes'])->name('generateFromNotes');



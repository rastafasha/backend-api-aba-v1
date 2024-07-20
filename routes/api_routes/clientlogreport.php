<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientLogReporController;

Route::get('clientlogreport', [ClientLogReporController::class, 'index'])->name('index');

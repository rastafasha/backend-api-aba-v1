<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Role\RolesController;
use App\Http\Controllers\Admin\Role\RoleV2Controller;

Route::resource('roles', RolesController::class);
Route::post('roles/store', [RolesController::class, 'store'])->name('store');
Route::get('roles/show/{role}', [RolesController::class, 'show'])->name('show');
Route::put('roles/update/{role}', [RolesController::class, 'update'])->name('update');
Route::delete('roles/destroy/{role}', [RolesController::class, 'destroy'])->name('destroy');



Route::prefix('v2/roles')->group(function () {
    Route::get('/', [RoleV2Controller::class, 'index']);
    Route::post('/', [RoleV2Controller::class, 'store']);
    Route::get('/{id}', [RoleV2Controller::class, 'show']);
    Route::put('/{id}', [RoleV2Controller::class, 'update']);
    Route::delete('/{id}', [RoleV2Controller::class, 'destroy']);
});

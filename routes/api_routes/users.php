<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminUserSoftDeletesController;
use App\Http\Controllers\UserV2Controller;

//Admin Usuarios
Route::get('/users', [AdminUserController::class, 'index'])
    ->name('users.index');

Route::get('/user/show/{user}', [AdminUserController::class, 'userShow'])
    ->name('user.show');

Route::put('/user/update/{user}', [AdminUserController::class, 'userUpdate'])
    ->name('user.update');

Route::delete('/user/destroy/{user}', [AdminUserController::class, 'userDestroy'])
    ->name('user.destroy');

Route::get('user/recientes/', [AdminUserController::class, 'recientes'])
    ->name('users.recientes');

Route::get('users/search/{request}', [AdminUserController::class, 'search'])
    ->name('users.search');



//Admin Usuarios Softdeletes
Route::get('/users/delete', [AdminUserSoftDeletesController::class, 'index'])
    ->name('users.delete.index');

Route::get('/user/delete/show/{id}', [AdminUserSoftDeletesController::class, 'userDeleteShow'])
    ->name('user.delete.show');

Route::put('/user/delete/restore/{id}', [AdminUserSoftDeletesController::class, 'userDeleteRestore'])
    ->name('user.delete.restore');

Route::delete('/user/destroy/force/{id}', [AdminUserSoftDeletesController::class, 'userDeleteforce'])
    ->name('user.delete.force');


// V2 routes
Route::prefix('v2/users')->group(function () {
    Route::get('/', [UserV2Controller::class, 'index']);
    Route::get('/{id}', [UserV2Controller::class, 'show']);
});

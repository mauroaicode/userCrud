<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\User\UserAPIController;

Route::prefix('user')->group(function () {

    Route::group(['middleware' => ['auth:api']], function () {

        Route::get('/list', [UserAPIController::class, 'getUsers']);
        Route::get('/{userId}', [UserAPIController::class, 'findUser']);
        Route::post('/create', [UserAPIController::class, 'createUser']);
        Route::delete('/{userId}/delete', [UserAPIController::class, 'deleteUser']);
        Route::put('/{userId}/update', [UserAPIController::class, 'updateUser']);
    });
});

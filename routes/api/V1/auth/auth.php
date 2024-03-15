<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\Auth\LoginAPIController;

Route::post('/login', [LoginAPIController::class, 'login']);

Route::group(['middleware' => ['auth:api']], function () {

    Route::post('/logout', [LoginAPIController::class, 'logout']);
});

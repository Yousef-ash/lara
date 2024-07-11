<?php

use App\Http\Controllers\apiAuthController;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;



Route::group(['middleware' => ['auth:sanctum']], function () {
    route::post('/devices', [ApiController::class, 'devices']);
    route::post('/sensors', [ApiController::class, 'sensors']);
    route::post('/lastsensor', [ApiController::class, 'latestsensor']);
    route::post('/status', [ApiController::class, 'status']);
    route::post('/device', [ApiController::class, 'chooseDevice']);
    Route::post('/logout', [apiAuthController::class, 'logout']);
    });
Route::post('/login', [apiAuthController::class, 'login']);

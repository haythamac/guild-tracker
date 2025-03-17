<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\SessionController;

Route::post('login', [SessionController::class, 'login']); 

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [SessionController::class, 'logout']); 
    Route::apiResource('players', PlayerController::class);
    Route::post('players/{player}/process-power', [PlayerController::class, 'powerProcessScreenshot']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;


Route::apiResource('players', PlayerController::class);
Route::post('players/{player}/process-power', [PlayerController::class, 'powerProcessScreenshot']);

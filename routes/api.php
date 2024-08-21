<?php

use App\Http\Controllers\APIHacksController;
use App\Http\Controllers\APIVersionController;
use Illuminate\Support\Facades\Route;
use App\Models\Hack;
use App\Http\Resources\HackResource;

Route::prefix('v1')->group(function () {
    Route::apiResource('/hacks', APIHacksController::class)->only(['index', 'show']);
    Route::apiResource('/version', APIVersionController::class)->only('show');
})->middleware('auth:sanctum');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CircleCIController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api')->group(function () {
    Route::post('circleci', [CircleCIController::class, 'handleNotification']);
    Route::get('circleci', [CircleCIController::class, 'getAllNotifications']);
});

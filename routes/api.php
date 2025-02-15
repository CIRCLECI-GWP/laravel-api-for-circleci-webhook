<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CircleCIController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('circleci', [CircleCIController::class, 'handleNotification']);
Route::get('circleci', [CircleCIController::class, 'getAllNotifications']);

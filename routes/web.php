<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CircleCIController;

Route::get('/', function () {
    return view('welcome');
});

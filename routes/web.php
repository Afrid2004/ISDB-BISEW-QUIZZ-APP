<?php

use App\Http\Controllers\RoundController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource("/rounds", RoundController::class);

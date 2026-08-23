<?php

use App\Http\Controllers\RoundController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('dashboard');

Route::get("/rounds/deleted", [RoundController::class, 'deletedRounds'])->name('rounds.deleted');
Route::resource("/rounds", RoundController::class);
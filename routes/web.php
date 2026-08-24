<?php

use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RoundController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('dashboard');


// rounds controller 
Route::get("/rounds/deleted", [RoundController::class, 'deletedRounds'])->name('rounds.deleted');
Route::resource("/rounds", RoundController::class);


// questions controller 
Route::resource("/questions", QuestionController::class);
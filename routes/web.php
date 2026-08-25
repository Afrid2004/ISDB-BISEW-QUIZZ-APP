<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RoundController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('dashboard');


// rounds controller 
Route::get("/rounds/deleted", [RoundController::class, 'deletedRounds'])->name('rounds.deleted');
Route::resource("/rounds", RoundController::class);

// courses controller 
Route::get("/courses/deleted", [CourseController::class, 'deletedCourses'])->name('courses.deleted');
Route::patch('/courses/{id}/restore', [CourseController::class, 'restoreCourses'])->name('courses.restore');
Route::delete('/courses/{id}/delete', [CourseController::class, 'forceDelete'])->name('courses.forceDelete');
Route::resource("/courses", CourseController::class);

// questions controller 
Route::resource("/questions", QuestionController::class);
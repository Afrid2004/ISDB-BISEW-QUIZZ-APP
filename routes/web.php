<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\ModuleController;
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

// module controller 
Route::get("/modules/deleted", [ModuleController::class, 'deletedModules'])->name('modules.deleted');
Route::patch('/modules/{id}/restore', [ModuleController::class, 'restoreModules'])->name('modules.restore');
Route::delete('/modules/{id}/delete', [ModuleController::class, 'forceDelete'])->name('modules.forceDelete');
Route::resource("/modules", ModuleController::class);

// questions controller 
Route::resource("/questions", QuestionController::class);
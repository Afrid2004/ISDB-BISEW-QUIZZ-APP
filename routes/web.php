<?php

use App\Http\Controllers\RoundController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\TrainingCenterController;
use App\Http\Controllers\BatchController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Application Dashboard Route
|--------------------------------------------------------------------------
|
| This is the entry point of the application backend system.
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('dashboard');


/*
|--------------------------------------------------------------------------
| Rounds Module Routes
|--------------------------------------------------------------------------
|
| Handles all routing operations for the Rounds module including 
| soft-deletes, restorations, permanent deletions, and resource endpoints.
|
*/

// GET: Display a listing of soft-deleted rounds
Route::get('rounds/deleted', [RoundController::class, 'deletedRounds'])
    ->name('rounds.deleted');

// PATCH: Restore a soft-deleted round back to active status
Route::patch('/rounds/restore/{id}', [RoundController::class, 'restore'])
    ->name('rounds.restore');

// DELETE: Permanently drop a soft-deleted round from the database
Route::delete('/rounds/force-delete/{id}', [RoundController::class, 'forceDelete'])
    ->name('rounds.forceDelete');

// RESOURCE: Generates standard CRUD routes (index, create, store, show, edit, update, destroy)
Route::resource('rounds', RoundController::class)
    ->names('rounds');


/*
|--------------------------------------------------------------------------
| Training Centers Module Routes
|--------------------------------------------------------------------------
|
| Handles routing operations for Training Centers, mapped directly
| with custom endpoints to manage system locations and deleted states.
|
*/

// GET: Display a listing of soft-deleted training centers
Route::get("/training-centers/deleted", [TrainingCenterController::class, 'deletedTrainingCenters'])
    ->name('training-centers.deleted');

// PATCH: Restore a soft-deleted training center back to active status
Route::patch('/training-centers/restore/{id}', [TrainingCenterController::class, 'restore'])
    ->name('training-centers.restore');

// DELETE: Permanently drop a soft-deleted training center from the database
Route::delete('/training-centers/force-delete/{id}', [TrainingCenterController::class, 'forceDelete'])
    ->name('training-centers.forceDelete');

// RESOURCE: Generates standard CRUD routes (index, create, store, show, edit, update, destroy)
Route::resource("training-centers", TrainingCenterController::class)
    ->names('training-centers');


/*
|--------------------------------------------------------------------------
| Shifts Module Routes
|--------------------------------------------------------------------------
|
| Handles all routing actions for time shifts, keeping schedules 
| structured for class operations.
|
*/

// GET: Display a listing of soft-deleted shifts
Route::get("/shifts/deleted", [ShiftController::class, 'deletedShifts'])
    ->name('shifts.deleted');

// PATCH: Restore a soft-deleted shift back to active status
Route::patch('/shifts/restore/{id}', [ShiftController::class, 'restore'])
    ->name('shifts.restore');

// DELETE: Permanently drop a soft-deleted shift from the database
Route::delete('/shifts/force-delete/{id}', [ShiftController::class, 'forceDelete'])
    ->name('shifts.forceDelete');

// RESOURCE: Generates standard CRUD routes (index, create, store, show, edit, update, destroy)
Route::resource("shifts", ShiftController::class)
    ->names('shifts');


/*
|--------------------------------------------------------------------------
| Batches Module Routes
|--------------------------------------------------------------------------
|
| Handles routing for Batches. Connects rounds, training centers, and shifts
| to create cohort structures for enrolling student groups.
|
*/

// GET: Display a listing of soft-deleted batches
Route::get("/batches/deleted", [BatchController::class, 'deletedBatches'])
    ->name('batches.deleted');

// PATCH: Restore a soft-deleted batch back to active status
Route::patch('/batches/restore/{id}', [BatchController::class, 'restore'])
    ->name('batches.restore');

// DELETE: Permanently drop a soft-deleted batch from the database
Route::delete('/batches/force-delete/{id}', [BatchController::class, 'forceDelete'])
    ->name('batches.forceDelete');

// RESOURCE: Generates standard CRUD routes (index, create, store, show, edit, update, destroy)
Route::resource("batches", BatchController::class)
    ->names('batches');
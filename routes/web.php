<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RoundController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\TrainingCenterController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\CompetencyUnitController;
use App\Http\Controllers\ElementController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;



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

//competency unit controller
Route::get('/competency-units/next-serial/{module}', [CompetencyUnitController::class, 'nextSerial'])->name('competency-units.next-serial');
Route::get('/competency-units/edit-next-serial/{moduleId}/{id}', [CompetencyUnitController::class, 'editNextSerial']);
Route::get('/competency-units/modules/{course}', [CompetencyUnitController::class, 'modulesByCourse'])->name('competency-units.modules');
Route::get('/competency-units/deleted', [CompetencyUnitController::class, 'deletedCompetencyUnits'])->name('competency-units.deleted');
Route::patch('/competency-units/{id}/restore', [CompetencyUnitController::class, 'restoreCompetencyUnit'])->name('competency-units.restore');
Route::patch('/competency-units/{id}/delete', [CompetencyUnitController::class, 'forceDelete'])->name('competency-units.forceDelete');
Route::resource('/competency-units', CompetencyUnitController::class);

// elements controller 
Route::get('/elements/deleted', [ElementController::class, 'deletedElements'])->name('elements.deleted');
Route::get('/elements/modules/{courseId}', [ElementController::class, 'modulesByCourse'])->name('elements.modules');
Route::get('/elements/competency-units/{moduleId}', [ElementController::class, 'competencyUnitsByModule'])->name('elements.competency-units');
Route::post('/elements/{id}/restore', [ElementController::class, 'restoreElement'])->name('elements.restore');
Route::delete('/elements/{id}/force-delete', [ElementController::class, 'forceDelete'])->name('elements.force-delete');
Route::resource('elements', ElementController::class);

// questions controller 
Route::get('/questions/modules/{courseId}', [QuestionController::class, 'getModules'])
    ->name('questions.modules');
Route::get('/questions/competency-units/{moduleId}', [QuestionController::class, 'getCompetencyUnits'])
    ->name('questions.competency-units');
Route::resource("/questions", QuestionController::class);


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



Route::get('/download-template', [QuestionController::class, 'exportTemplate'])->name('questions.export-template');
Route::post('/questions/import', [QuestionController::class, 'import'])->name('questions.import');




Route::post('/students/import',[StudentController::class,'import'])->name('students.import');
Route::get('/students/export-template',[StudentController::class,'exportTemplate'])->name('students.export-template');
Route::resource('/students', StudentController::class)->names('students');


<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApprenticeController;
use App\Http\Controllers\ComputerController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\CourseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', '/apprentices');
Route::get('/apprentices', [ApprenticeController::class, 'index'])->name('apprentices.index');
Route::get('/computers', [ComputerController::class, 'index'])->name('computers.index');
Route::get('/areas', [AreaController::class, 'index'])->name('areas.index');
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    
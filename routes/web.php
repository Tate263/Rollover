<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentProgramStatus;

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

// Route to display the program selection form
Route::get('/', [StudentProgramStatusController::class, 'index'])->name('program-selection');

// Route to handle the rollover process
Route::post('/rollover', [StudentProgramStatusController::class, 'rollOver'])->name('rollover');
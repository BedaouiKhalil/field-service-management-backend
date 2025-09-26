<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

// redirection (root /)
Route::get('/', HomeController::class);

Route::middleware(['auth'])->name('admin.')->prefix('dashboard')->group(function () {
    Route::view('/', 'admin.dashboard.index')->name('index');
});


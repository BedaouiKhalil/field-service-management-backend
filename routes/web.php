<?php

use App\Http\Controllers\Web\CustomerController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\TaskController;
use App\Http\Controllers\Web\UserController;
use Illuminate\Support\Facades\Route;

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
//Route::get('/', HomeController::class);



Route::middleware(['auth'])->name('admin.')->prefix('dashboard')->group(function () {
    Route::view('/', 'admin.dashboard.index')->name('index');

    Route::get('customers/search', [CustomerController::class, 'search'])->name('customers.search');
    Route::get('users/search', [UserController::class, 'searchUsers'])->name('users.search');

    Route::resource('customers', CustomerController::class);
    Route::resource('users', UserController::class);
    Route::resource('tasks', TaskController::class);

    
});

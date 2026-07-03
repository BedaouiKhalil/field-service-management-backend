<?php

use App\Helpers\ApiResponse;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\api\CustomerController;
use App\Http\Controllers\Api\WilayaController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);
    });

    Route::get('wilayas/{wilaya}/communes', [WilayaController::class, 'communes']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::apiResource('customers', CustomerController::class);

        Route::patch('tasks/{task}/status', [TaskController::class, 'updateStatus']);
        Route::apiResource('tasks', TaskController::class);
    });
});

Route::fallback(function () {
    return ApiResponse::error(message: 'Route not found.', code: Response::HTTP_NOT_FOUND);
});

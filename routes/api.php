<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\OrderController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function() {
        return auth()->user();
    });
    Route::get('/get-order/{order}', [OrderController::class, 'show']);
    Route::post('/auth-check', [LoginController::class, 'check']);
    Route::post('/logout', [LoginController::class, 'logout']);
});

Route::get('/get-orders/{restorant}', [OrderController::class, 'index']);
Route::post('/update-order-status/{order}', [OrderController::class, 'updateStatus']);
Route::post('/sanctum/token', [LoginController::class, 'createToken']);

<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\VariantResource;

use App\Models\Product;
use App\Models\Order;
use App\Models\Variant;


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
        return auth()->user()->restorant->load('user');
    });
    Route::get('/get-order/{order}', [OrderController::class, 'show']);
    Route::post('/auth-check', [LoginController::class, 'check']);
    Route::post('/logout', [LoginController::class, 'logout']);
});

Route::get('/get-orders/{restorant}', [OrderController::class, 'index']);
Route::post('/update-order-status/{order}', [OrderController::class, 'updateStatus']);
Route::post('/sanctum/token', [LoginController::class, 'createToken']);


Route::get('/order/test/{id}', function($id) {
    return OrderResource::make(Order::findOrFail($id));
});
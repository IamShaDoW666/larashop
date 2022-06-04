<?php

use App\Http\Controllers\DebugController;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RestorantController;
use App\Models\Product;
use App\Models\Restorant;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/products', function() {
    return Product::all();
});
Route::get('/debug', [DebugController::class, 'test'])->name('api.debug');
Route::get('/restorants/{restorant:slug}', [DebugController::class, 'show']);

Route::get('/hours', function() {
    return Restorant::find(1)->hours;
});
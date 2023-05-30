<?php

use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\PurchaseController;
use App\Http\Controllers\API\SupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [LoginController::class, 'login']);
Route::get('active-products', [ProductController::class, 'getActiveProduct']);

Route::middleware(['api', 'auth:sanctum'])->group(function () {
    Route::post('logout', [LoginController::class, 'logout']);

    Route::apiResource('products', ProductController::class);

    Route::get('suppliers', [SupplierController::class, 'index']);

    Route::post('purchases', [PurchaseController::class, 'store']);
});

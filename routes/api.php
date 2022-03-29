<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::put('products/update/{id}', [\App\Http\Controllers\ProductController::class, 'update']);


    Route::get('products/product-list', [\App\Http\Controllers\ProductController::class, 'index']);
    Route::post('products/store', [\App\Http\Controllers\ProductController::class, 'store']);
    Route::get('products/show/{id}', [\App\Http\Controllers\ProductController::class, 'show']);

    Route::delete('products/delete/{id}', [\App\Http\Controllers\ProductController::class, 'destroy']);
});
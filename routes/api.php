<?php

use App\Http\Controllers\Api\ProductCategoryController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
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

// user
Route::group([
    'controller' => UserController::class,
    'middleware' => 'assign.guard:api'
], function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::middleware('jwt.verify')->get('/logout', 'logout');
    Route::middleware('jwt.verify')->get('/profile', 'profile');
});

// product category
Route::group([
    'controller' => ProductCategoryController::class,
    'middleware' => 'assign.guard:api',
    'prefix' => 'category-product'
], function () {
    Route::middleware('jwt.verify')->get('/', 'getAll');
    Route::middleware('jwt.verify')->get('/{id}', 'getOne');
    Route::middleware('jwt.verify')->post('/', 'store');
    Route::middleware('jwt.verify')->post('/{id}', 'update');
    Route::middleware('jwt.verify')->delete('/{id}', 'destroy');
});

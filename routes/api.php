<?php

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

<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JWTController;
use App\Http\Controllers\Users_controller;

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
    Route::post('/login', [JWTController::class, 'login']);
    Route::post('/register', [JWTController::class, 'register']);
    Route::post('/logout', [JWTController::class, 'logout']);
    Route::post('/refresh', [JWTController::class, 'refresh']);
    Route::get('/user-profile', [JWTController::class, 'userProfile']);    
});

Route::group([
    'middleware' => 'api',
], function ($router) {
    Route::put('/user/update', [Users_controller::class, 'update']);
    Route::get('/user/list', [Users_controller::class, 'findAll']);
    Route::delete('/user/delete/{id}', [Users_controller::class, 'deleteOne']);
    Route::delete('/user/delete', [Users_controller::class, 'deleteAll']);
        
});
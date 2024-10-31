<?php
use App\Http\Controllers\Front\FrontController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => '/'], function(){
    Route::get('/', [FrontController::class, 'home']);
    Route::get('/login', [FrontController::class, 'login']);
    Route::get('/signup', [FrontController::class, 'signup']);
    Route::get('/logout', [FrontController::class, 'logout']);
    Route::post('/login', [FrontController::class, 'doLogin']);
    Route::post('/signup', [FrontController::class, 'doSignup']);
});

Route::fallback(function () {
    return response()->view('Front.errors.404', [], 404);
});
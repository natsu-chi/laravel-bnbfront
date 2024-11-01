<?php
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Front\ListingController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => '/'], function(){
    Route::get('/', [FrontController::class, 'home']);
    Route::get('/login', [FrontController::class, 'login']);
    Route::get('/signup', [FrontController::class, 'signup']);
    Route::get('/logout', [FrontController::class, 'logout']);
    Route::post('/login', [FrontController::class, 'doLogin']);
    Route::post('/signup', [FrontController::class, 'doSignup']);
});

Route::group(['prefix' => '/properties'], function(){
    // /search?location={city_name}&checkin={10/1/2024}&checkout{10/1/2024}=&adults=2&children=0&pets=0
    Route::get('/search', [ListingController::class, 'listByQueries']);
    Route::get('/search/url', [ListingController::class, 'getByUrl']);
    Route::get('/{id}', [ListingController::class, 'getById']);
});

Route::fallback(function () {
    return response()->view('Front.errors.404', [], 404);
});
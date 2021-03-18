<?php

use App\Http\Middleware\AccessToken;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => AccessToken::class], function () {
    Route::view('/', 'dashboard');
});

//Route::ohDearWebhooks('/oh-dear-webhooks');

Route::middleware(['auth:sanctum'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
   Route::post('/auth/register', [RegisteredUserController::class, 'store']);
   Route::post('/auth/login', [AuthenticatedSessionController::class, 'store']);

   Route::middleware('auth:api')->group(function () {
       Route::post('/card', [CardController::class, 'store']);
       Route::get('/merchant', [MerchantController::class, 'index']);
       Route::post('/merchant', [MerchantController::class, 'store']);
   });
});





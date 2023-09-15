<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\User\AuthenticatedSessionController;
use App\Http\Controllers\User\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
   Route::post('/auth/register', [RegisteredUserController::class, 'store']);
   Route::post('/auth/login', [AuthenticatedSessionController::class, 'store']);

   Route::middleware('auth:api')->group(function () {
       Route::post('/card', [CardController::class, 'store']);
   });
});





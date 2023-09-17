<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\GetTaskHistory;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
   Route::post('/auth/register', [RegisteredUserController::class, 'store']);
   Route::post('/auth/login', [AuthenticatedSessionController::class, 'store']);

   Route::middleware('auth:api')->group(function () {
       Route::get('/card', [CardController::class, 'index']);
       Route::post('/card', [CardController::class, 'store']);

       Route::get('/merchant', [MerchantController::class, 'index']);
       Route::post('/merchant', [MerchantController::class, 'store']);

       Route::post('/task', [TaskController::class, 'store']);
       Route::patch('/task/{task}', [TaskController::class, 'update']);

       Route::get('/task-history', GetTaskHistory::class);
   });
});





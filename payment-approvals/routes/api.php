<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\PaymentApprovalController;
use App\Http\Controllers\API\TravelPaymentController;

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

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::post('/payments', [PaymentController::class, 'store'])
    ->middleware(['auth:sanctum', 'abilities:create-payment']);

Route::post('/travel-payments', [TravelPaymentController::class, 'store'])
    ->middleware(['auth:sanctum', 'abilities:create-payment']);

Route::middleware(['auth:sanctum', 'ability:approvals'])->group(function () {
    Route::get('/payments', [PaymentController::class, 'index']);
    Route::get('/payments/{id}', [PaymentController::class, 'show']);
    Route::put('/payments/{id}', [PaymentController::class, 'update']);
    Route::delete('/payments/{id}', [PaymentController::class, 'destroy']);

    Route::get('/travel-payments', [TravelPaymentController::class, 'index']);
    Route::get('/travel-payments/{id}', [TravelPaymentController::class, 'show']);
    Route::put('/travel-payments/{id}', [TravelPaymentController::class, 'update']);
    Route::delete('/travel-payments/{id}', [TravelPaymentController::class, 'destroy']);
    
    Route::controller(PaymentApprovalController::class)->group(function () {
        Route::post('approve', 'store');
        Route::get('report', 'report');
    });
});
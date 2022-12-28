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

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('payments', PaymentController::class);
    Route::resource('travel-payments', TravelPaymentController::class);
    
    Route::controller(PaymentApprovalController::class)->group(function () {
        Route::post('approve', 'store');
        Route::post('report', 'report');
    });
});

<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\appController;


Route::post('/common/signup', [appController::class, 'signup']);
Route::post('/common/verify-user-otp', [appController::class, 'requestVerifyContactNumber']);
Route::post('/common/request-user-otp', [appController::class, 'requestUserOtp']);

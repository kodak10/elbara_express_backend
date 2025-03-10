<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\VerificationController;


Route::post('register', [RegisterController::class, 'register']);
Route::get('check-pseudo', [RegisterController::class, 'checkPseudo']);
Route::get('check-phone', [RegisterController::class, 'checkPhone']);
Route::post('send-otp', [VerificationController::class, 'sendOTP']);

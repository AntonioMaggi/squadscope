<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\RegistrationController;

Route::post('/submit_registration', [RegistrationController::class, 'store'])->name('registration.store');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login/{provider}', [SocialLoginController::class, 'redirectToProvider']);
Route::get('/login/{provider}/callback', [SocialLoginController::class, 'handleProviderCallback'])->name('social.login.callback');



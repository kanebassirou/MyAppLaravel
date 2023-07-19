<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// les routes pour controller HomeController
Route::controller(HomeController::class)->group(function(){
    Route::get('/', 'home')->name('app_home');
    Route::get('/about','about')->name('app_about');
    Route::match(['get','post'],'/dashboard','dashboard')->middleware('auth')
    ->name('app_dashboard');//utilisateur ne peut pas acceder a la page dashbord si il n'est pas connecter
});

// les routes pour controller LoginController
Route::controller(LoginController::class)->group(function(){
    Route::get('/logout','logout')->name('app_logout');
    Route::post('/exist_email','existEmail')->name('app_existEmail');
    Route::match(['get', 'post'], '/activation_code/{token}','activationCode')->name('app_activation_code');
    Route::get('/user_checher','userChecher')->name('app_user_checher');
    Route::get('/resend_activation_code/{token}','resendActivationCode')->name('app_resend_activation_code');
    Route::get('/activation_account_link/{token}','activationAccountLink')->name('app_activation_account_link');
    Route::match(['get', 'post'], '/activation_account_change_email/{token}','activationAccountChangeEmail')->name('app_activation_account_change_email');
    Route::match(['get','post'],'/forgot_password','forgotPassword')->name('app_forgot_password');
    Route::match(['get','post'],'/change_password/{token}','changePassword')->name('app_change_password');
});



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


Route::group(['middleware' => 'web'], function () {
    // Routes du contrôleur HomeController
    Route::get('/', [HomeController::class, 'home'])->name('app_home');
    Route::get('/about', [HomeController::class, 'about'])->name('app_about');
    Route::match(['get', 'post'], '/dashboard', [HomeController::class, 'dashboard'])
        ->middleware('auth')
        ->name('app_dashboard');

    // Routes du contrôleur LoginController
    Route::get('/logout', [LoginController::class, 'logout'])->name('app_logout');
    Route::post('/exist_email', [LoginController::class, 'existEmail'])->name('app_existEmail');
    Route::match(['get', 'post'], '/activation_code/{token}', [LoginController::class, 'activationCode'])->name('app_activation_code');
    Route::get('/user_checher', [LoginController::class, 'userChecher'])->name('app_user_checher');
    Route::get('/resend_activation_code/{token}', [LoginController::class, 'resendActivationCode'])->name('app_resend_activation_code');
    Route::get('/activation_account_link/{token}', [LoginController::class, 'activationAccountLink'])->name('app_activation_account_link');
    Route::match(['get', 'post'], '/activation_account_change_email/{token}', [LoginController::class, 'activationAccountChangeEmail'])->name('app_activation_account_change_email');
});


// Route::get('/', [HomeController::class,'home'])
// ->name('app_home');
// Route::get('/about', [HomeController::class,'about'])
// ->name('app_about');
// Route::match(['get','post'],'/dashboard',[HomeController::class,'dashboard'])
// //utilisateur ne peut pas acceder a la page dashbord si il n'est pas connecter
// ->middleware('auth')
// ->name('app_dashboard');
// Route::get('/logout',[LoginController::class,'logout'])
// ->name('app_logout');
// Route::post('/exist_email',[LoginController::class,'existEmail'])
// ->name('app_existEmail');
// Route::match(['get', 'post'], '/activation_code/{token}',[LoginController::class,'activationCode'])
// ->name('app_activation_code');
// Route::get('/user_checher', [LoginController::class,'userChecher'])
// ->name('app_user_checher');
// Route::get('/resend_activation_code/{token}',[LoginController::class,('resendActivationCode')])
// ->name('app_resend_activation_code');
// Route::get('/activation_account_link/{token}',[LoginController::class,('activationAccountLink')])
// ->name('app_activation_account_link');
// Route::match(['get', 'post'], '/activation_account_change_email/{token}',[LoginController::class,('activationAccountChangeEmail')])
// ->name('app_activation_account_change_email');

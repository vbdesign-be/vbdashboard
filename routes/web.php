<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SettingsController;
use App\Mail\UserLoginMail;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [LoginController::class, "login"])->name('login');
Route::get('/register', [LoginController::class, "register"]);
Route::post('/user/register', [LoginController::class, "store"]);
Route::post('/user/login', [LoginController::class, "canLogin"]);
Route::get('/logout', [Logincontroller::class, "logout"]);

// Route::get('/connect', [DashboardController::class, "getConnection"]);
Route::get('/teamleader', [DashboardController::class, "connectTeamleader"]);



Route::group(['middleware' => ['auth']], function() {
    Route::get('/', [UserController::class, "dashboard"]);
    Route::get('/profile', [UserController::class, "profile"]);
    Route::post('/user/editUser/{id}', [UserController::class, "editUser"]);
});

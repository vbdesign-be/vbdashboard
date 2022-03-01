<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\teamleaderController;
use App\Mail\UserLoginMail;
use Illuminate\Http\Request;

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

// //eiegencode
// Route::get('/connect', [DashboardController::class, "connectTeamleader"]);
// Route::get('/teamleader', [DashboardController::class, "loadView"]);
// Route::post('/token', [DashboardController::class, "token"]);

// justijn
// Route::get('/connect', [DashboardController::class, "connectTeamleader"]);
// Route::get('/teamleader', [DashboardController::class, "loadView"]);

// Route::get('/teamleader', [SettingsController::class, 'index'])->name('settings.index');
// Route::post('/teamleader/authorize', [SettingsController::class, 'redirectForAuthorization'])->name('settings.teamleader.authorize');
// Route::get('/teamleader/accept', [SettingsController::class, 'accept']);

// //madeItBelgium
Route::get('/connect', [teamleaderController::class, "requestToken"]);
Route::get('/teamleader', [teamleaderController::class, "teamleader"]);
Route::get('/contacts', [teamleaderController::class, "contacts"]);
Route::get('/companies', [teamleaderController::class, "companies"]);
Route::get('/facturen', [teamleaderController::class, "facturen"]);
Route::get('/offertes', [teamleaderController::class, "offertes"]);



Route::group(['middleware' => ['auth']], function() {
    Route::get('/', [UserController::class, "dashboard"]);
    Route::get('/profile', [UserController::class, "profile"]);
    Route::post('/user/editUser/{id}', [UserController::class, "editUser"]);
});

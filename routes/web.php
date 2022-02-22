<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StatistiekController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\OfferteController;
use App\Http\Controllers\AfspraakController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\SupportController;
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


Route::group(['middleware' => ['auth']], function() {

    Route::get('/profiel', [UserController::class, "profile"]);
    Route::post('/user/update', [UserController::class, "updateUser"]);

    //projecten
    Route::get('/', [ProjectController::class, "projects"]);

    //statistieken
    Route::get('/statistieken', [StatistiekController::class, "statistieken"]);

    Route::get('/shop', [ShopController::class, "shop"]);

    Route::get('/offerte', [OfferteController::class, "offerte"]);

    Route::get('/afspraak', [AfspraakController::class, "afspraak"]);

    //support
    Route::get('/faq', [SupportController::class, "support"]);
    Route::get('/ask', [SupportController::class, "askQuestion"]);
    Route::post('/support/addQuestion', [SupportController::class, "store"]);
    Route::get('/status', [SupportController::class, "status"]);

    //company
    Route::post('/company/update', [CompanyController::class, "update"]);
});

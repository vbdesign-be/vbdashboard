<?php

use App\Http\Controllers\DashboardController;
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
Route::post('/user/login', [LoginController::class, "canLogin"]);
Route::get('/logout', [Logincontroller::class, "logout"]);



// //madeItBelgium
Route::get('/connect', [teamleaderController::class, "requestToken"]);
Route::get('/teamleader', [teamleaderController::class, "teamleader"]);
Route::get('/contacts', [teamleaderController::class, "contacts"]);
Route::get('/companies', [teamleaderController::class, "companies"]);
Route::get('/facturen', [teamleaderController::class, "facturen"]);
Route::get('/offertes', [teamleaderController::class, "offertes"]);

Route::get('/register', [teamleaderController::class, "register"]);
Route::get('/registerBert', [teamleaderController::class, "registerBert"]);
Route::get('/updateBert', [teamleaderController::class, "updateBert"]);




Route::group(['middleware' => ['auth']], function() {

    //user
    Route::get('/profiel', [UserController::class, "profile"]);
    Route::post('/user/update', [UserController::class, "updateUser"]);
    Route::post('/user/updateAvatar', [UserController::class, "updateAvatar"]);
    
    //company
    Route::get('/company/{id}', [CompanyController::class, "company"]);
    Route::post('company/update', [CompanyController::class, "updateCompany"]);

    //projecten
    Route::get('/', [ProjectController::class, "projects"]);

    //statistieken
    Route::get('/statistieken', [StatistiekController::class, "statistieken"]);

    Route::get('/shop', [ShopController::class, "shop"]);

    //offerte
    Route::get('/offerte', [OfferteController::class, "offerte"]);
    Route::post('/offerte/post', [OfferteController::class, "post"]);

    Route::get('/afspraak', [AfspraakController::class, "afspraak"]);

    //support
    Route::get('/faq', [SupportController::class, "support"]);
    Route::get('/ask', [SupportController::class, "askQuestion"]);
    Route::post('/support/addQuestion', [SupportController::class, "store"]);
    Route::get('/status', [SupportController::class, "status"]);

    
    
});

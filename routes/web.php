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
use App\Http\Controllers\ClickupController;
use App\Http\Controllers\DomeinController;
use App\Http\Controllers\VimexxController;
use App\Mail\UserLoginMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
Route::get('/register', [teamleaderController::class, "register"]);

Route::get('/connectClickup', [ClickupController::class, "requestToken"]);
Route::get('/clickup', [ClickupController::class, "accessToken"]);
Route::get('/getTasks', [ClickupController::class, "getTasks"]);


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
    Route::post('/project/addBugfix', [ProjectController::class, 'addBugfix']);
    Route::get('/project/bugfix/{id}', [ProjectController::class, 'bugfix']);
    Route::get('/project/{id}', [ProjectController::class, 'detail']);
    Route::post('/project/addPhoto', [ProjectController::class, 'addPhoto']);
    

    //statistieken
    Route::get('/statistieken', [StatistiekController::class, "statistieken"]);

    //shop
    Route::get('/shop', [ShopController::class, "shop"]);
    Route::post('/shop/search', [ShopController::class, "searchDomain"]);
    Route::post('/shop/winkelmandje', [ShopController::class, "Cart"]);
    Route::post('/shop/buy/domain', [ShopController::class, "buyDomain"]);
    Route::post('/shop/buy/email', [ShopController::class, "buyEmail"]);
    Route::get('/payed', [ShopController::class, "payed"]);

    //domeinen
    Route::get('/domeinen', [DomeinController::class, "domeinen"]);
    Route::post('/domein/email/delete', [DomeinController::class, "deleteEmail"]);
    Route::get('/domein/{domein}', [DomeinController::class, "detail"]);
    

    //offerte
    Route::get('/offerte', [OfferteController::class, "offerte"]);
    Route::post('/offerte/post', [OfferteController::class, "post"]);
    Route::get('getDeal/{id}', [OfferteController::class, "getDeal"]);

    Route::get('/afspraak', [AfspraakController::class, "afspraak"]);

    //support
    Route::get('/faq', [SupportController::class, "support"]);
    Route::get('/ask', [SupportController::class, "askQuestion"]);
    Route::post('/support/addQuestion', [SupportController::class, "store"]);
    Route::get('/status', [SupportController::class, "status"]);

    

    
    
});

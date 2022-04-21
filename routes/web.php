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
use App\Http\Controllers\FreshdeskController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DomeinController;
use App\Http\Controllers\FacturenController;
use App\Http\Livewire\AddTag;
use App\Mail\UserLoginMail;
use App\Models\Order;
use App\Models\Vimexx;





use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
    Route::get('/home', [ProjectController::class, "projects"]);
    Route::post('/project/addBugfix', [ProjectController::class, 'addBugfix']);
    Route::get('/project/bugfix/{id}', [ProjectController::class, 'bugfix']);
    Route::get('/project/{id}', [ProjectController::class, 'detail']);
    Route::post('/project/addPhoto', [ProjectController::class, 'addPhoto']);
    

    //statistieken
    Route::get('/statistieken', [StatistiekController::class, "statistieken"]);

    //shop
    Route::get('/shop', [ShopController::class, "shop"]);
    Route::post('/shop/search', [ShopController::class, "searchDomain"]);
    Route::post('/shop/winkelmandje', [ShopController::class, "cart"]);
    Route::post('/shop/transfer', [ShopController::class, "cartTransfer"]);
    Route::post('/shop/buy/domain', [ShopController::class, "buyDomain"]);
    Route::post('/shop/transfer/domain', [ShopController::class, "transferDomain"]);
    Route::post('/shop/buy/email', [ShopController::class, "buyEmail"]);
    Route::get('/payed', [ShopController::class, "payed"]);
    Route::get('/payedEmail', [ShopController::class, "payedEmail"]);
    Route::get('/payedTransfer', [ShopController::class, "payedTransfer"]);

    //domeinen
    Route::get('/domein', [DomeinController::class, "domeinen"]);
    Route::get('/domein/{domain}', [DomeinController::class, "detail"]);
    Route::get('/domein/{domain}/email', [DomeinController::class, 'emailDetail']);
    Route::post('/domein/email/delete', [DomeinController::class, "deleteEmail"]);
    Route::get('/domein/{domain}/nameservers', [DomeinController::class, 'nameserversDetail']);
    Route::post('/domein/nameservers/update', [DomeinController::class, 'updateNameservers']);
    Route::get('/domein/{domain}/dns', [DomeinController::class, 'dnsDetail']);
    Route::Post('/domein/dns/add', [DomeinController::class, 'dnsAdd']);
    Route::Post('/domein/dns/edit', [DomeinController::class, 'dnsEdit']);
    Route::Post('/domein/dns/delete', [DomeinController::class, 'dnsDelete']);
    Route::Post('/domein/delete', [DomeinController::class, 'domainDelete']);
    

    //offerte
    Route::get('/offerte', [OfferteController::class, "offerte"]);
    Route::post('/offerte/post', [OfferteController::class, "post"]);
    Route::get('getDeal/{id}', [OfferteController::class, "getDeal"]);

    //facturen
    Route::get('/facturen', [FacturenController::class, "getFacturen"]);
    Route::get('/factuur/download/{id}', [FacturenController::class, "downloadFactuur"]);

    //afspraak
    Route::get('/afspraak', [AfspraakController::class, "afspraak"]);

    //support
    Route::get('/support', [SupportController::class, "support"]);
    Route::get('/support/faq', [SupportController::class, "faq"]);
    Route::get('/support/tickets', [SupportController::class, "tickets"]);
    Route::get('/support/ticket/{ticket}',[SupportController::class, "detailTicket"]);
    Route::post('/support/ticket/add', [SupportController::class, "addTicket"]);
    Route::post('/support/ticket/reaction/add', [SupportController::class, "addReactionUser"]);
    Route::post('/support/ticket/statusUpdate', [SupportController::class, "statusUpdate"]);

    //tickets
    Route::get('/tickets', [TicketController::class, "getTickets"]);
    Route::get('/ticket/account/{id}', [TicketController::class, "getUser"]);
    Route::get('/ticket/{id}', [TicketController::class, "detailTicket"]);
    Route::post('/ticket/statusUpdate', [TicketController::class, "statusUpdate"]);
    Route::post('/ticket/priorityUpdate', [TicketController::class, "priorityUpdate"]);
    Route::post('/ticket/typeUpdate', [TicketController::class, "typeUpdate"]);
    Route::post('/ticket/reaction/add', [TicketController::class, "addReactionAgent"]);
    Route::post('/ticket/spam/add', [TicketController::class, "spam"]);
    Route::get('/ticket/samenvoegen/{id}', [TicketController::class, "samenvoegPage"]);
    Route::post('/tickets/merge', [TicketController::class, "ticketsMerge"]);
    Route::post('/ticket/delete', [TicketController::class, "deleteTicket"]);
    Route::post('/ticket/send', [TicketController::class, "ticketSend"]);


    Route::get('/ask', [SupportController::class, "askQuestion"]);
    Route::post('/support/addQuestion', [SupportController::class, "store"]);
    Route::get('/status', [SupportController::class, "status"]);

    

    
    
});

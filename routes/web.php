<?php

use App\Http\Controllers\ClientAuthController;
use App\Http\Controllers\ClientDashboradController;
use App\Http\Controllers\OrderController;
use App\Http\Livewire\AnalyticsLivewire;
use App\Http\Livewire\ClientAccountTransaction;
use App\Http\Livewire\Clients\ClientsAddOrder;
use App\Http\Livewire\MyOrders;
use App\Http\Livewire\OrderTraker;
use App\Http\Livewire\ReturedOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route as FacadesRoute;
use Illuminate\Support\Facades\Session;

// FacadesRoute::get('client-login' , [ClientAuthController::class, 'index']);
Auth::routes(['register' => false]);
FacadesRoute::get('login', fn () => view('auth.login'))->name('login');
FacadesRoute::get('register', fn () => view('auth.register'))->name('login');


// FacadesRoute::post()
FacadesRoute::get('caputre', fn () => view('caputre'));
FacadesRoute::get('locale/{locale}', function ($locale) {

    Session::put('locale', $locale);

    return redirect()->back();
})->name('switchLan');

FacadesRoute::get('LTEe', fn () => view('LTE'));
FacadesRoute::get('EDU', fn () => view('layouts.Edum'));

FacadesRoute::get('practiles', fn () => view('index'));
// FacadesRoute::group(['prefix' => LaravelLocalization::setLocale(),
// 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
// ], function(){
FacadesRoute::get('FacadesRoute', fn () => 'Hello')->name('home');
FacadesRoute::post('login', [ClientAuthController::class, 'Login'])->name('client_login');
FacadesRoute::post('register_client', [ClientAuthController::class, 'register_client'])->name('register_client');
FacadesRoute::get('un-aproved', fn () => view('un_approved'))->middleware('auth:client');

FacadesRoute::middleware('approved', 'auth:client')->group(function () {
    FacadesRoute::get('dashboard', [ClientDashboradController::class, 'index']);
    FacadesRoute::get('/', [ClientDashboradController::class, 'index']);
    FacadesRoute::get('add-orders/{id}', ClientsAddOrder::class)->name('addOrder');
    FacadesRoute::get('order-history',  [ClientDashboradController::class, 'OrderHistory'])->name('OrderHistory');
    FacadesRoute::get('/order-details/{id}', [OrderController::class, 'show'])->name('orders.show.details');
    FacadesRoute::get('order-traking', OrderTraker::class)->name('orderTraking');

    FacadesRoute::get('account-transaction', [App\Http\Controllers\AccountTransaction::class, 'index'])->name('accountTransaction');
    FacadesRoute::get('show-profile', [ClientDashboradController::class, 'profile'])->name('profile');
    FacadesRoute::post('print-invoices', [App\Http\Controllers\OrderController::class, 'printInvoices'])->name('print.invoices');
    FacadesRoute::get('/{id}/invoice', [App\Http\Controllers\OrderController::class, 'printInvoice'])->name('print.invoice');
    FacadesRoute::get('/analytics', AnalyticsLivewire::class)->name('analytics');
    FacadesRoute::get('/returend-order', ReturedOrder::class)->name('ReturedOrder');
    FacadesRoute::get('/my-order', MyOrders::class)->name('MyOrders');
});

<?php

use App\Http\Controllers\DeployController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('default.index');
});
Route::get('/index.html', function () {
    return view('default.index');
});
Route::get('about-us.html', function () {
    return view('default.about-us');
});
Route::get('account.html', function () {
    return view('default.account');
});
Route::get('activity.html', function () {
    return view('default.activity');
});
Route::get('activity-2', function () {
    return view('default.activity-2');
});
Route::get('author.html', function () {
    return view('default.author');
});
Route::get('contact.html', function () {
    return view('default.contact');
});
Route::get('display.html', function () {
    return view('default.display');
});
Route::get('explore-v5.html', function () {
    return view('default.explore-v5');
});
Route::get('index-5.html', function () {
    return view('default.index-5');
});
Route::get('login-v2.html', function () {
    return view('default.login-v2');
});
Route::get('payment-methods.html', function () {
    return view('default.payment-methods');
});
Route::get('purchases-sales.html', function () {
    return view('default.purchases-sales');
});
Route::get('seller-settings.html', function () {
    return view('default.seller-settings');
});
Route::get('create.html', function () {
    return view('default.create');
});
Route::get('explore.html', function () {
    return view('default.explore');
});
Route::get('explore-v6.html', function () {
    return view('default.explore-v6');
});
Route::get('index-6.html', function () {
    return view('default.index-6');
});
Route::get('news-detail.html', function () {
    return view('default.news-detail');
});
Route::get('product-details-v1.html', function () {
    return view('default.product-details-v1');
});
Route::get('ranking.html', function () {
    return view('default.ranking');
});
Route::get('transactions.html', function () {
    return view('default.transactions');
});
Route::get('create-multiple.html', function () {
    return view('default.create-multiple');
});
Route::get('explore-v2.html', function () {
    return view('default.explore-v2');
});
Route::get('index-2.html', function () {
    return view('default.index-2');
});
Route::get('index-7.html', function () {
    return view('default.index-7');
});
Route::get('news.html', function () {
    return view('default.news');
});
Route::get('product-details-v2.html', function () {
    return view('default.product-details-v2');
});
Route::get('redeem.html', function () {
    return view('default.redeem');
});
Route::get('wallet.html', function () {
    return view('default.wallet');
});
Route::get('create-single.html', function () {
    return view('default.create-single');
});
Route::get('explore-v3.html', function () {
    return view('default.explore-v3');
});
Route::get('index-3.html', function () {
    return view('default.index-3');
});
Route::get('notifications.html', function () {
    return view('default.notifications');
});
Route::get('product-details-v3.html', function () {
    return view('default.product-details-v3');
});
Route::get('register.html', function () {
    return view('default.register');
});
Route::get('wallet-v2.html', function () {
    return view('default.wallet-v2');
});
Route::get('deposit.html', function () {
    return view('default.deposit');
});
Route::get('explore-v4.html', function () {
    return view('default.explore-v4');
});
Route::get('index-4.html', function () {
    return view('default.index-4');
});
Route::get('login.html', function () {
    return view('default.login');
});
Route::get('offers.html', function () {
    return view('default.offers');
});
Route::get('profile.html', function () {
    return view('default.profile');
});
Route::get('security.html', function () {
    return view('default.security');
});


Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/logout', function(){
    Auth::logout();
    return Redirect::to('login');
 });
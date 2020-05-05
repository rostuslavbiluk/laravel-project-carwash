<?php

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
Auth::routes(['register' => false, 'verify' => false, 'reset' => false]);

Route::get('/', function () { return view('index'); })->name('/');

Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

//Route::get('/notify/index', 'NotificationController@index');
//Route::get('/', 'HomeController@test');
//Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('dashboard')->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard.index');//->middleware('auth');
    Route::get('articles', 'ArticlesController@index')->name('articles.index');
    Route::get('articles/{code?}', 'ArticlesController@show')->name('articles.show');

    Route::get('settings', 'SettingsController@index')->name('settings.index');
    Route::get('settings/{code?}', 'SettingsController@show')->name('settings.show');

    Route::get('support', 'SupportController@index')->name('support.index');
    Route::post('support/successful', 'SupportController@create')->name('support.send');
});

Route::prefix('dashboard/ajax')->group(function () {
    Route::post('change_status_order', 'HomeController@setStatusOrder')->name('status.change.order');
    Route::post('change_status_entity', 'HomeController@setStatusEntity')->name('status.change.entity');

    Route::post('notify/get_notification_user', 'NotificationController@get_notification_user');
    Route::post('notify/read_notification', 'NotificationController@read_notification');
});

Route::prefix('dashboard/profile')->group(function () {
    Route::get('/', 'UserController@profile')->name('profile');
    Route::post('edit/{user?}', 'UserController@edit')->name('profile.edit');

    Route::get('requisites', 'PaymentInvoiceController@index')->name('requisites.index');
    Route::post('requisites/edit/{requisites?}', 'PaymentInvoiceController@edit')->name('requisites.edit');

    Route::post('paymentcard/add', 'PaymentInvoiceController@addCard')->name('card.create');
    Route::post('paymentcard/remove', 'PaymentInvoiceController@deleteCard')->name('card.delete');

    Route::get('services', 'ServicesController@index')->name('services.index');
    Route::post('services/edit', 'ServicesController@edit')->name('services.edit');
    Route::post('services/price/edit', 'ServicesController@updatePrice')->name('services.price.edit');
});

/** @TODO необходима переработка логики полностью всего функционала iblock */
Route::prefix('dashboard/iblock')->group(function () {
    Route::get('/', 'IblockController@index')->name('iblock.index');
    Route::get('type', 'IblockController@showTypeIblock')->name('iblock.type');
    Route::get('type/delete/{id?}', 'IblockController@typeIblockDelete')->name('iblock.type.delete');
    Route::match(['get', 'post'], 'type/add/{id?}', 'IblockController@typeIblockAdd')->name('iblock.type.add');
    Route::match(['get', 'post'], 'type/edit/{id?}', 'IblockController@typeIblockAdd')->name('iblock.type.edit');

    Route::get('list/{code}', 'IblockController@showListIblock')->name('iblock.list');
    Route::get('list{code}/add', 'IblockController@addElementIblock')->name('iblock.list.add');
    Route::post('list{code}/add', 'IblockController@saveElementIblock')->name('iblock.list.save');
    Route::get('list{code}/edit/{id?}', 'IblockController@addElementIblock')->name('iblock.list.edit');
    Route::get('list{sEntityCode}/delete/{nId}', 'IblockController@deleteElement')->name('iblock.list.delete');
});

<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group([
    'middleware' => 'api',
    /*'prefix' => 'auth'*/
], function ($router) {
    
    Route::post('login', 'Api\AuthController@login');
    Route::post('logout', 'Api\AuthController@logout');
    Route::get('refresh', 'Api\AuthController@refresh');
    Route::get('me', 'Api\AuthController@me');
    Route::post('register', 'Api\AuthController@register');
    Route::post('confirm_code', 'Api\AuthController@confirmCode');
    Route::post('new_confirm_code', 'Api\AuthController@newConfirmCode');
    Route::post('refresh_token', 'Api\AuthController@refreshToken');

    Route::get('payment_options', 'Api\ApiCommandController@payments');
    Route::get('brands', 'Api\ApiCommandController@brands');
    Route::get('services', 'Api\ApiCommandController@services');
    Route::get('category', 'Api\ApiCommandController@category');

    Route::get('user_profiles', 'Api\ProfileController@index');
    Route::put('change_active_profile/{id}', 'Api\ProfileController@activate');
    Route::post('add_profile', 'Api\ProfileController@store');
    Route::get('show_profile/{id}', 'Api\ProfileController@show');
    Route::delete('delete_profile/{id}', 'Api\ProfileController@destroy');
    Route::put('edit_profile/{id}', 'Api\ProfileController@update');

    Route::get('get_entity', 'Api\EntityController@index');

    Route::get('get_order_history', 'Api\OrderController@history');
    Route::post('get_order_status', 'Api\OrderController@status');
    Route::post('user_make_order', 'Api\OrderController@store');

    Route::get('create_notification_user', 'NotificationController@create_notification_user');
});


/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

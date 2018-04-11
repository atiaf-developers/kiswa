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

Route::get('user', function (Request $request) {
    return _api_json(false, 'user');
})->middleware('jwt.auth');
Route::group(['namespace' => 'Api'], function () {



    Route::get('/token', 'BasicController@getToken');
    Route::get('/settings', 'BasicController@getSettings');

    Route::get('get_donation_types', 'BasicController@getCategories');
    Route::get('get_news', 'BasicController@getNews');
    Route::get('get_cooperating_socities', 'BasicController@getCooperatingSocities');
    Route::get('get_common_questions', 'BasicController@getCommonQuestions');
    Route::get('get_rate_questions', 'BasicController@getRateQuestions');
    Route::get('get_communication_guides', 'BasicController@getCommunicationGuides');
    Route::post('send_contact_message', 'BasicController@sendContactMessage');
    
    

    
    Route::post('login', 'LoginController@login');
    Route::post('register', 'RegisterController@register');
    Route::get('setting', 'BasicController@getSettings');

    Route::group(['middleware' => 'jwt.auth'], function () {

        Route::post('user/update', 'UserController@update');
        Route::post('rate', 'BasicController@rate');
       

      
    });
});

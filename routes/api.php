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

    Route::get('get_categories', 'BasicController@getCategories');
    Route::get('get_category', 'BasicController@getCategory');
    Route::get('get_news', 'BasicController@getNews');
    Route::get('get_donation_types', 'BasicController@getDonationTypes');
    Route::get('get_activities', 'BasicController@getActivities');
    Route::get('get_videos', 'BasicController@getVideos');
    Route::get('get_communication_guides', 'BasicController@getCommunicationGuides');
    Route::post('send_contact_message', 'BasicController@sendContactMessage');
    
       
    Route::resource('donation_requests','DonationRequestsController');

    
    Route::post('login', 'LoginController@login');
    Route::post('register', 'RegisterController@register');
    Route::post('send_verification_code', 'RegisterController@sendVerificationCode');

    Route::get('setting', 'BasicController@getSettings');

    Route::group(['middleware' => 'jwt.auth'], function () {

        Route::post('user/update', 'UserController@update');
        Route::post('rate', 'BasicController@rate');

        // Delegate < start >
            // Container < start >
            Route::get('log_dump', 'ContainersController@Logdump');
            // Container < end >
        // Delegate < end >

      
    });
});

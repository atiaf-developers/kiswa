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


$languages = array('ar', 'en', 'fr');
$defaultLanguage = 'ar';
if ($defaultLanguage) {
    $defaultLanguageCode = $defaultLanguage;
} else {
    $defaultLanguageCode = 'ar';
}

$currentLanguageCode = Request::segment(1, $defaultLanguageCode);
if (in_array($currentLanguageCode, $languages)) {
    Route::get('/', function () use($defaultLanguageCode) {
        return redirect()->to($defaultLanguageCode);
    });

 
    Route::group(['namespace' => 'Front', 'prefix' => $currentLanguageCode], function () use($currentLanguageCode) {
        app()->setLocale($currentLanguageCode);
        Route::get('/', 'HomeController@index')->name('home');
        Route::get('getRegionByCity/{id}', 'AjaxController@getRegionByCity');
        Route::get('getAddress/{id}', 'AjaxController@getAddress');
        Route::get('ajax/checkAvailability', 'AjaxController@checkAvailability');
        Route::post('ajax/reserve_submit', 'AjaxController@reserve_submit');
        Auth::routes();

        Route::get('user-activation-code', 'Auth\RegisterController@showActivationForm')->name('activation');
        Route::post('activateuser', 'Auth\RegisterController@activate_user')->name('activationuser');

        Route::get('edit-user-phone', 'Auth\RegisterController@showEditMobileForm')->name('edit-phone');
        Route::post('edituserphone', 'Auth\RegisterController@EditPhone')->name('editphone');

        Route::get('login/facebook', 'Auth\RegisterController@redirectToProvider')->name('login/facebook');
        Route::get('login/facebook/callback', 'Auth\RegisterController@handleProviderCallback');
        
        Route::get('complete-registeration', 'Auth\RegisterController@showCompleteRegistrationForm')->name('complete_register');
        

        Route::get('about-us', 'StaticController@about_us')->name('about_us');
        Route::get('usage-and-conditions', 'StaticController@usage_coditions')->name('usage_conditions');
        Route::get('policy', 'StaticController@policy')->name('policy');
        Route::get('contact-us', 'StaticController@contact_us')->name('contact_us');
        Route::get('offers', 'StaticController@offers')->name('offers');
        Route::post('contact_us', 'StaticController@sendContactMessage')->name('contact');
        Route::get('categories', 'PropertyController@categories');
        Route::get('category/{slug}', 'PropertyController@category_details');
        Route::get('games', 'PropertyController@games');
        Route::get('game/{slug}', 'PropertyController@game_details');
        Route::get('game/{slug}/reserve', 'PropertyController@game_reserve');
       


        /*************************** user ***************/
        Route::get('customer/reservations','ReservationsController@index')->name('reservations');


        
        

    });
} else {
    Route::get('/' . $currentLanguageCode, function () use($defaultLanguageCode) {
        return redirect()->to($defaultLanguageCode);
    });
}


//Route::group(['middleware'=>'auth:admin'], function () {
Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::get('/', 'AdminController@index')->name('admin.dashboard');
    Route::get('/error', 'AdminController@error')->name('admin.error');
    Route::get('/change_lang', 'AjaxController@change_lang')->name('ajax.change_lang');

     Route::get('profile', 'ProfileController@index');
    Route::patch('profile', 'ProfileController@update');



    Route::resource('groups', 'GroupsController');
    Route::resource('admins', 'AdminsController');

    Route::resource('cooperating_societies', 'CooperatingSocietiesController');
    Route::resource('activities', 'ActivitiesController');
    Route::post('pilgrims/import', 'PilgrimsController@import');
    Route::post('pilgrims/data', 'PilgrimsController@data');
    Route::resource('locations', 'LocationsController');
    Route::resource('our_locations', 'OurLocationsController');
    Route::resource('categories', 'CategoriesController');
    Route::resource('news', 'NewsController');
    Route::resource('videos', 'VideosController');

    Route::get('settings', 'SettingsController@index');
  
    // Route For Container Moduel {Start}
    Route::resource('container', 'ContainersController');
    Route::post('container/data', 'ContainersController@data');
    // Route For Container Moduel {End}





    Route::post('settings', 'SettingsController@store');
    Route::get('notifications', 'NotificationsController@index');
    Route::get('reservations', 'ReservationsController@index');
    Route::post('notifications', 'NotificationsController@store');




    Route::post('groups/data', 'GroupsController@data');
    Route::post('locations/data', 'LocationsController@data');


 
   
    

    Route::post('admins/data', 'AdminsController@data');
   
 Route::resource('contact_messages', 'ContactMessagesController');
    Route::post('contact_messages/data', 'ContactMessagesController@data');

    Route::post('categories/data', 'CategoriesController@data');
    Route::post('videos/data', 'VideosController@data');
    Route::post('cooperating_societies/data', 'CooperatingSocietiesController@data');
    Route::post('activities/data', 'ActivitiesController@data');
    Route::post('news/data', 'NewsController@data');
   

    

 




    $this->get('login', 'LoginController@showLoginForm')->name('admin.login');
    $this->post('login', 'LoginController@login')->name('admin.login.submit');
    $this->get('logout', 'LoginController@logout')->name('admin.logout');
});
//});


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

Auth::routes();

Route::any('agreement/', 'HomeController@agreement');
Route::get('/', 'Auth\LoginController@showLoginForm');
Route::post('login', 'Auth\LoginController@login')->name('adminlogin');
Route::post('logout', 'Auth\LoginController@logout')->name('adminlogout');
Route::get('logout/request', 'Auth\LoginController@getLogout')->name('getLogout');

Route::group(['middleware' => ['admin.auth','checkStaff','Agreement','UserLoginType']], function () {

    Route::get('home/{type?}/{id?}', 'HomeController@index');

    Route::match(['get', 'post'], 'setting', 'HomeController@setting')->name('sitesetting');

    Route::get('country/status/{country}/{status}', 'CountryController@status')->name('countrytatus');
    Route::resource('country', 'CountryController');
    Route::get('city/status/{city}/{status}', 'CityController@status')->name('citystatus');
    Route::resource('city', 'CityController');
    Route::get('city/index/{country}', 'CityController@index')->name('countrycity');

    Route::get('users/profile', 'UsersController@profile')->name('adminprofile');

    Route::get('users/index/{type}', 'UsersController@index')->name('userlist');
    Route::get('users/create/{type}', 'UsersController@create')->name('usercreate');

    Route::resource('users', 'UsersController');
    Route::post('users/getcity', 'UsersController@getcity')->name('getcity');
    Route::get('users/status/{user}/{status}', 'UsersController@status')->name('userstatus');

    Route::resource('property', 'PropertyController');

    Route::post('users/getsubtype', 'PropertyController@getsubtype')->name('getsubtype');
    Route::post('property/gethostlists', 'PropertyController@gethostlists')->name('gethostlists');
    Route::post('property/gethosttype', 'PropertyController@gethosttype')->name('gethosttype');
    Route::get('property/gallery/{property}', 'PropertyController@gallery')->name('propertygallery');
    Route::post('property/updategallery/{property}', 'PropertyController@updategallery')->name('updategallery');
    Route::get('property/removegallery/{property}/{gallery_id}', 'PropertyController@removegallery')->name('removegallery');
    Route::get('property/status/{property}/{status}', 'PropertyController@status')->name('propertystatus');

    Route::get('pages/index/{pagename}', 'PagesController@index')->name('pageview');
    Route::post('pages/index/{pagename}', 'PagesController@index')->name('pagepost');
    Route::resource('policy', 'PolicyController');
#Route::resource('term', 'TermController');

    Route::resource('memberships', 'MembershipsController');
    Route::get('memberships/makedefault/{user}', 'MembershipsController@makedefault')->name('makedefault');

    Route::resource('amenity', 'AmenityController');
    Route::resource('services', 'ServicesController');
    Route::resource('offers', 'OffersController');
    Route::resource('coupons', 'CouponsController');

    Route::get('request/hosts/', 'RequestController@hosts')->name('hostsrequest');
    Route::get('request/hostreply/{id}', 'RequestController@hostreply')->name('hostreply');
    Route::put('request/hostreply/{id}', 'RequestController@hostreply')->name('posthostreply');
    Route::get('request/hostshow/{id}', 'RequestController@hostshow')->name('hostshow');

    Route::get('bookings', 'BookingController@index')->name('bookings');
    Route::get('bookings/view/{id}', 'BookingController@view')->name('viewbooking');
    Route::get('booking/update/{id}/{value}', 'BookingController@bookingStatus')->name('updateBooking');

    Route::get('guestcare', 'HomeController@guestcare')->name('guestcarelist');
    Route::get('guestcare/view/{id}', 'HomeController@guestcaredetail')->name('guestcaredetail');
    Route::post('guestcare/post/{id}', 'HomeController@guestcaredetail')->name('postguestcaredetail');

    /* notification */
    Route::get('notification/getname', 'notifyController@getUsers')->name('getname');
    Route::resource('notification', 'notifyController');

    /* commission controller */
    Route::get('commission/getUsers', 'CommissionController@getUsers')->name('getUserData');
    Route::resource('commission','CommissionController');
  
    /* wallet controller */
    Route::resource('wallet','WalletController');

    /* challan controller */    
    Route::get('challan/delete','ChallanController@delete');
    Route::resource('challan','ChallanController');

    /* payment controller  */
    Route::get('payment/cancel', 'PaymentController@paycancel')->name('payment.cancel');
    Route::get('payment/return/{code}/{token}', 'PaymentController@payreturn')->name('payment.return');
    Route::post('payment/store', 'PaymentController@store')->name('payment.store');
    
    /* chat */
    Route::get('message/{userId?}', 'ChatController@index')->name('showmessage');
    Route::post('message/selectuser',
    function () {
        $userId = $_POST['userId'];
        return redirect()->route('showmessage', $userId);
    }
    )->name('startchat');
    Route::get('chat/getuser', 'ChatController@getUsers')->name('chatGetUser');
    Route::resource('message/', 'ChatController');

});

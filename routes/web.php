<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routesd for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'HomeController@welcome')->name('welcome');

Auth::routes();

Route::get('/ajaxlogin', 'Auth\LoginController@showAjaxLoginForm')->name('ajaxlogin');


Route::get('/home', 'HomeController@index')->name('home');

Route::get('/privacy-policy', 'HomeController@privacy')->name('privacy-policy');

Route::match(['get', 'post'], '/guest-care', 'HomeController@guestcare')->name('guestcare');
Route::get('/guest-care/{id?}', 'HomeController@guestcareView')->name('guestcareView');

Route::get('/users/activation/{token}', 'UsersController@activation')->name('useractivation');
Route::get('/users/profile', 'UsersController@profile')->name('userprofile');
Route::patch('/users/update', 'UsersController@update')->name('userupdate');
Route::get('/users/changepassword', 'UsersController@changepassword')->name('changepassword');
Route::post('/users/passwordupdate', 'UsersController@passwordupdate')->name('passwordupdate');

Route::get('/users/cards', 'UsersController@cards')->name('usercard');

Route::get('/users/cardadd', 'UsersController@cardadd')->name('cardadd');
Route::post('/users/cardsave', 'UsersController@cardsave')->name('cardsave');
Route::get('/users/carddelete/{card_id}', 'UsersController@carddelete')->name('carddelete');

Route::any('/users/{type}/bookings/', 'UsersController@bookings')->name('userbookings')->where(['service' => 'previous|upcoming']);
Route::get('/users/wallet', 'UsersController@wallet')->name('userwallet');

Route::get('/property', 'PropertyController@index')->name('properties');
Route::get('/property/gallery/{id}', 'PropertyController@gallery')->name('propertiegallery');
Route::any('/property/favorite', 'PropertyController@favorite')->name('myfavorite');
Route::post('/property/makefavorite', 'PropertyController@makefavorite')->name('makefavorite');
Route::get('/property/view/{property}', 'PropertyController@view')->name('viewproperty');
Route::match(['get', 'post'], '/property/search', 'PropertyController@search')->name('searchproperty');


Route::get('/users/becomehost', 'UsersController@becomehost')->name('becomehost');
Route::post('/users/becomehost', 'UsersController@becomehost')->name('postbecomehost');

Route::get('/users/offers', 'UsersController@offers')->name('useroffers');

Route::post('/login/social', 'Auth\LoginController@sociallogin')->name('sociallogin');

Route::get('/login/redirect/{service}', 'Auth\LoginController@socialredirect')->where(['service' => 'facebook|google']);
Route::get('/login/{service}/callback', 'Auth\LoginController@socialcallback')->where(['service' => 'facebook|google']);


/* chat */
Route::resource('message/', 'ChatController');
Route::get('message/{userId?}', 'ChatController@index')->name('showmessage');

/* notification  */
Route::resource('notification', 'NotifyController');


//Bookings
Route::match(['get', 'post'], '/bookings/summary/{id}', 'BookingController@summary')->name('bookingssummary');
Route::post('/bookings/save', 'BookingController@save')->name('bookingsave');
//Route::get('/bookings/payment/{id}', 'BookingController@bookingpayment')->name('bookingpayment');
Route::post('/bookings/payment', 'BookingController@bookingpayment')->name('bookingpayment');
Route::post('/bookings/checkoffer', 'BookingController@checkoffer')->name('checkoffer');
Route::post('/bookings/bookingconfirm', 'BookingController@bookingconfirm')->name('bookingconfirm');
Route::post('/bookings/bookingUpdate', 'BookingController@bookingUpdate')->name('bookingUpdate');
Route::get('/bookings/delete/{id}', 'BookingController@delete')->name('bookingdelete');

/* payment URL */
Route::post('/bookings/paymentUpdate', 'BookingController@updatePayment')->name('paymentUpdate');

Route::post('/wallet/addmoney', 'PaymentController@store')->name('addMoney');
Route::get('payment/cancel', 'PaymentController@paycancel')->name('payment.cancel');
Route::get('payment/return/{token}', 'PaymentController@payreturn')->name('payment.return');
Route::post('payment/store', 'PaymentController@store')->name('payment.store');


//Ajax data route
Route::post('ajax/getcity', 'AjaxController@getcity')->name('getcity');
Route::post('ajax/getcityForHost', 'AjaxController@getcityForHost')->name('getcityForHost');
Route::post('ajax/getpropertytype', 'AjaxController@getpropertytype')->name('getpropertytype');
Route::get('ajax/getUserDetail/{id}', 'AjaxController@getUserDetail')->name('getUserDetail');
Route::get('ajax/getBookingDetail/{id}', 'AjaxController@getBookingDetail')->name('getBookingDetail');
Route::any('ajax/addReview/{id?}', 'AjaxController@addReview')->name('addReview');
Route::get('ajax/getReviews/{id}', 'AjaxController@getReviews')->name('getReviews');



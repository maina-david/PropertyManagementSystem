<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
   return $request->user();
});


//c2b daraja integreation
Route::get('daraja/payment/callback/{businessID}','app\settings\integrations\payments\mpesa\daraja\callbackController@payment_confirmation')->name('daraja.payment.callback');
Route::get('daraja/payment/cancellation/{businessID}','app\settings\integrations\payments\mpesa\daraja\callbackController@payment_cancel')->name('daraja.payment.cancel.callback');
Route::get('daraja/validation/{businessID}','app\settings\integrations\payments\mpesa\daraja\callbackController@url_validation')->name('daraja.validation.url');

//callbacks
Route::post('/callbacks/kepler9',['uses' => 'app\callbacks\callbacksController@kepler9', 'as' => 'callback.kepler9']);
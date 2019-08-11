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

Route::get('/', function () {
	// if (config('app.env') == 'local') {
		return view('welcome');
	// }
    // return redirect('/admin');
});

Auth::routes();
Route::post('wechat/mobile', 'Auth\LoginController@getPhone');

Route::middleware('auth')->group(function () {
	// Route::get('cancel/top/supply/and/demands/{supply_and_demand}', 'Admin\SupplyAndDemandsController@cancelTopSupplyAndDemand');
	// Route::get('recommend/supply/and/demands/{supply_and_demand}', 'Admin\SupplyAndDemandsController@recommendSupplyAndDemand');
	// Route::get('supply/and/demands', 'SupplyAndDemandsController@storeSupplyAndDemand');
	// 	Route::get('industries', 'HomeController@industries');
	// Route::get('user/supply/and/demands', 'UsersController@userSupplyAndDemands');
	Route::get('home', 'HomeController@home');
	Route::get('industries', 'HomeController@industries');
});
Route::get('/user/supply/and/demands', 'UsersController@userSupplyAndDemands');
Route::get('supply/and/demands/{supply_and_demand}', 'SupplyAndDemandsController@show');


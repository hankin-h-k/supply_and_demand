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
	if (config('app.env') == 'local') {
		return view('welcome');
	}
    return redirect('/admin');
});

Auth::routes();
Route::post('wechat/mobile', 'Auth\LoginController@getPhone');

// Route::middleware('auth')->group(function () {
	

// });

Route::get('supply/and/demands', 'SupplyAndDemandsController@index');
Route::get('supply/and/demands/{supply_and_demand}', 'SupplyAndDemandsController@show');
Route::get('collect/supply/and/demands/{supply_and_demand}', 'SupplyAndDemandsController@collectApplyAndDemand');
Route::get('my/collects', 'UsersController@myCollects');
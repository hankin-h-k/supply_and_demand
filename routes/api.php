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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('wechat/login', 'Auth\LoginController@loginWechat');
Route::post('wechat/register', 'Auth\LoginController@wechatRegister'); 
Route::post('wechat/mobile', 'Auth\LoginController@getPhone');

Route::post('login', 'Auth\LoginController@login');

//获取上传签名
Route::get('upload/signature', 'Controller@aliyunSignature');

Route::middleware(['auth:api'])->group(function () {
	//登出
	Route::post('logout','Auth\LoginController@logout');
	//重置密码
    Route::post('admin/reset/password', 'Auth\ResetPasswordController@resetPassword');
    // Route::middleware(['add_form_id'])->group(function(){
		/**
		 * 供需
		 */
		//列表
		Route::get('supply/and/demands', 'SupplyAndDemandsController@index');
		//详情
		Route::get('supply/and/demands/{supply_and_demand}', 'SupplyAndDemandsController@show');
		//申请供需
		Route::post('supply/and/demands', 'SupplyAndDemandsController@storeSupplyAndDemand');
		//收藏
		Route::post('collect/supply/and/demands/{supply_and_demand}', 'SupplyAndDemandsController@collectApplyAndDemand');

		/**
		 * 我的
		 */
		//我的
		Route::get('user', 'UsersController@user');
		//修改简历
		Route::put('user', 'UsersController@updateUser');
		//修改头像
		Route::put('user/avatar', 'UsersController@updateUserAvatar');
		//修改微信信息
		Route::put('wechat', 'UsersController@updateWechat');
		//我的收藏
		Route::get('my/collects', 'UsersController@myCollects');
		//我的发布
		Route::get('/user/supply/and/demands', 'UsersController@user@userSupplyAndDemands');

		/**
		 * 首页
		 */
		Route::get('home', 'HomeController@home');

		/**
		 * 联系方式及
		 */
		Route::get('link/info', 'HomeController@linInfo');

		/**
		 * 地区
		 */
		Route::get('addresses', 'HomeController@addresses');

		/**
		 * 行业列表
		 */
		Route::get('industries', 'HomeController@industries');

		/**
		 * 文章
		 */
		Route::get('articles', 'HomeController@articles');
		Route::get('articles/{article}', 'HomeController@article');
    // });
	//图片上传
	Route::post('uploads', 'Controller@upload');

});


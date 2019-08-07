<?php

use Illuminate\Http\Request;



Route::middleware('auth:api')->group(function () {
	/**
	 * 用户
	 */
	//用户列表
	Route::get('users', 'UsersController@users');
	//用户详情
	Route::get('users/{user}', 'UsersController@user');
	//通知用户
	Route::post('inform/user/{user}', 'UsersController@informUser');
	//屏蔽用户
	Route::put('shield/users/{user}', 'UsersController@shieldUser');
	//用户报名列表
	Route::get('users/{user}/applycations', 'UsersController@userApplycations');
	//新增用户
	Route::get('new/user/num', 'UsersController@newUserNum');

	/**
	 * 管理员
	 */
	//管理员列表
	Route::get('admins', 'UsersController@adminUsers');
	//修改管理员
	Route::put('users/{user}/admin', 'UsersController@updateAdmin');
	//添加管理员
	Route::post('admins', 'UsersController@storeAdmin');
	//删除管理员
	Route::delete('users/{user}/admin', 'UsersController@deleteAdmin');

	/**
	 * 广告
	 */
	//广告列表
	Route::get('ads', 'AdsController@ads');
	//广告详情
	Route::get('ads/{ad}', 'AdsController@ad');
	//广告添加
	Route::post('ads', 'AdsController@storeAd');
	//广告删除
	Route::delete('ads/{ad}', 'AdsController@deleteAd');
	//广告修改
	Route::put('ads/{ad}', 'AdsController@updateAd');

	/**
	 * 文章
	 */
	//文章列表
	Route::get('articles', 'ArticlesController@articles');
	//文章详情
	Route::get('articles/{article}', 'ArticlesController@article');
	//文章创建
	Route::post('articles', 'ArticlesController@storeArticle');
	//文章修改
	Route::put('articles/{article}', 'ArticlesController@updateArticle');
	//文章删除
	Route::delete('articles/{article}', 'ArticlesController@deleteArticle');

	/**
	 * 添加联系信息
	 */
	Route::get('link/info', 'UsersController@linkInfo');
	Route::post('link/info', 'UsersController@updateLinkInfo');

	/**
	 * 供需
	 */
	//取消置顶
	Route::put('cancel/top/supply/and/demands/{supply_and_demand}', 'SupplyAndDemandsController@cancelTopSupplyAndDemand');
	//置顶
	Route::put('top/supply/and/demands/{supply_and_demand}', 'SupplyAndDemandsController@topSupplyAndDemand');
	//列表
	Route::get('supply/and/demands', 'SupplyAndDemandsController@supplyAndDemands');
	//详情
	Route::get('supply/and/demands/{supply_and_demand}', 'SupplyAndDemandsController@supplyAndDemands');
	//修改状态
	Route::put('supply/and/demands/{supply_and_demand}/status', 'SupplyAndDemandsController@updateSupplyAndDemandStatus');
	//推荐
	Route::put('recommend/supply/and/demands/{supply_and_demand}', 'SupplyAndDemandsController@recommendSupplyAndDemand');
});

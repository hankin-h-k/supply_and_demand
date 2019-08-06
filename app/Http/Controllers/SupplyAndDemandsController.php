<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupplyAndDemand;
use App\Models\Collect;
class SupplyAndDemandsController extends Controller
{
	/**
	 * 供需列表
	 */
    public function index(Request $request, SupplyAndDemand $supply_and_demand)
    {
    	$type = $request->input('type', 'SUPPLY');
    	$supply_and_demands = $supply_and_demand->where('type', $type)->where('status', 'UNDERWAY');
    	$keyword = $request->input('keyword');
        if ($keyword) {
         	$keyword = trim('keyword');
         	$supply_and_demands = $supply_and_demands->where(function($sql) use($keyword){
            	$sql->where('title', 'like', '%'.$keyword.'%');
          	});
        }
        $industry_id = $request->input('industry_id');
        if ($industry_id) {
            $supply_and_demands = $supply_and_demands->where('industry_id', $industry_id);
        }
        $city = $request->input('city');
        if ($city) {
            $supply_and_demands = $supply_and_demands->where('city', $city);
        }
        $order = $request->input('order');
        if ($order == 'new') {
            $supply_and_demands = $supply_and_demands->orderBy('id', 'desc');
        }else{
            $supply_and_demands = $supply_and_demands->orderBy('is_top', 'desc')->orderBy('id', 'desc');
        }      

        $supply_and_demands = $supply_and_demands->paginate();
        foreach ($supply_and_demands as $supply_and_demand) {
        	$supply_and_demand->pics = json_decode($supply_and_demand->pics, true);
        }
        return $this->success('ok', $supply_and_demands);
    }

    /**
     * 供需详情
     */
    public function show(Request $request, SupplyAndDemand $supply_and_demand)
    {
    	$supply_and_demand->pics = json_decode($supply_and_demand->pics, true);
    	$supply_and_demand->industry;
    	//隐藏微信
    	$supply_and_demand->link_wechat = substr_replace($supply_and_demand->link_wechat, '********', 3);
    	//隐藏email
    	$link_email_arr = explode('@', $supply_and_demand->link_email);
    	$link_email_arr[0] = substr_replace($link_email_arr[0], '*****', 3);
    	$supply_and_demand->link_email = implode('@', $link_email_arr);
    	//隐藏联系方式
    	$supply_and_demand->link_mobile = substr_replace($supply_and_demand->link_mobile, '********', 3);
    	return $this->success('ok', $supply_and_demand);
    }

    /**
     * 收藏
     */
    public function collectApplyAndDemand(Request $request, SupplyAndDemand $supply_and_demand, Collect $collect)
    {
    	$user = auth()->user();
    	$user->collect($supply_and_demand);
    	return $this->success('ok');
    }




}

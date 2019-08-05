<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApplyAndDemand;
class ApplyAndDemandsController extends Controller
{
	/**
	 * 供需列表
	 */
    public function index(Request $request, ApplyAndDemand $apply_and_demand)
    {
    	$type = $request->input('type', 'APPLY');
    	$apply_and_demands = $apply_and_demand->where('type', $type)->where('status', 'UNDERWAY');
    	$keyword = $request->input('keyword');
        if ($keyword) {
         	$keyword = trim('keyword');
         	$apply_and_demands = $apply_and_demands->where(function($sql) use($keyword){
            	$sql->where('title', 'like', '%'.$keyword.'%');
          	});
        }
        $industry_id = $request->input('industry_id');
        if ($industry_id) {
            $apply_and_demands = $apply_and_demands->where('industry_id', $industry_id);
        }
        $city = $request->input('city');
        if ($city) {
            $apply_and_demands = $apply_and_demands->where('city', $city);
        }
        $order = $request->input('order');
        if ($order == 'new') {
            $apply_and_demands = $apply_and_demands->orderBy('id', 'desc');
        }else{
            $apply_and_demands = $apply_and_demands->orderBy('is_top', 'desc')->orderBy('id', 'desc');
        }      

        $apply_and_demands = $apply_and_demands->paginate();
        foreach ($apply_and_demands as $apply_and_demand) {
        	$apply_and_demand->pics = json_decode($apply_and_demand->pics, true);
        }
        return $this->success('ok', $apply_and_demands);
    }

    /**
     * 供需详情
     */
    public function show(Request $request, ApplyAndDemand $apply_and_demand)
    {
    	$apply_and_demand->pics = json_decode($apply_and_demand->pics, true);
    	$apply_and_demand->industry;
    	//隐藏微信
    	$apply_and_demand->link_wecaht = substr_replace($apply_and_demand->link_wecaht, '********', 3);
    	//隐藏email
    	$link_email_arr = explode('@', $apply_and_demand->link_email);
    	$link_email_arr[0] = substr_replace($link_email_arr[0], '*****', 3);
    	$apply_and_demand->link_email = implode('@', $link_email_arr);
    	//隐藏联系方式
    	$apply_and_demand->link_mbile = substr_replace($apply_and_demand->link_mbile, '********', 3);
    	return $this->success('ok', $apply_and_demand);
    }






}

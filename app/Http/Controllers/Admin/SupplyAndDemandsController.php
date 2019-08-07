<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SupplyAndDemand;

class SupplyAndDemandsController extends Controller
{
    /**
     * 列表
     */
    public function supplyAndDemands(Request $request, SupplyAndDemand $supply_and_demand)
    {   
        $supply_and_demands = $supply_and_demand->orderBy('id', 'desc');
        $status = $request->input('status');
        if ($status && $status != 'ALL') {
            $supply_and_demands = $supply_and_demands->where('status', $status);
        }
        $type = $request->input('type');
        if ($type && $type != 'ALL') {
        	$supply_and_demands = $supply_and_demands->where('type', $type);
        }
        $keyword = $request->input('keyword');
        if ($keyword) {
            $supply_and_demands = $supply_and_demands->where('title', 'like', '%'.$keyword.'%');
        }
        $supply_and_demands = $supply_and_demands->paginate();
    	return $this->success('ok', $supply_and_demands);
    }

    /**
     * 详情
     */
    public function supplyAndDemand(Request $request, SupplyAndDemand $supply_and_demand)
    {
    	$supply_and_demand->industry;
    	$supply_and_demand->pics = json_decode($supply_and_demand->pics, true);
    	return $this->success('ok', $supply_and_demand);
    }

    // public function updateSupplyAndDemand(Request $request, SupplyAndDemand $supply_and_demand)
    // {

    // }

    /**
     * 修改状态
     */
    public function updateSupplyAndDemandStatus(Request $request, SupplyAndDemand $supply_and_demand)
    {
    	$status = $request->input('status');
    	$supply_and_demand->update(['status'=>$status]);
    	return $this->success('ok');
    }

    /**
     * 修改推荐
     */
    public function recommendSupplyAndDemand(Request $request, SupplyAndDemand $supply_and_demand)
    {
        $supply_and_demand->is_recommend = $supply_and_demand->is_recommend?0:1;
        $supply_and_demand->save();
        return $this->success('ok', $supply_and_demand);
    }

    public function topSupplyAndDemand(Request $request, SupplyAndDemand $supply_and_demand)
    {
        $supply_and_demand->top();
        return $this->success('ok');
    }

    public function cancelTopSupplyAndDemand(Request $request, SupplyAndDemand $supply_and_demand)
    {
    	$supply_and_demand->cancelTop();
        return $this->success('ok');
    }
}

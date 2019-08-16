<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SupplyAndDemand;
use App\Models\Industry;
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

    public function updateSupplyAndDemand(Request $request, SupplyAndDemand $supply_and_demand)
    {
        if ($request->input('title') && $request->title != $supply_and_demand->title) {
            $supply_and_demand->title = $request->title;
        }
        if ($request->input('pics') && is_array($request->pics) && json_encode($request->pics) != $supply_and_demand->pics) {
            $supply_and_demand->pics = json_encode($request->pics);
        }
        if ($request->input('type') && $request->type != $supply_and_demand->type) {
            $supply_and_demand->type = $request->type;
        }
        if ($request->input('status') && $request->status != $supply_and_demand->status) {
            $supply_and_demand->status = $request->status;
        }
        if ($request->input('industry_id') && $request->industry_id != $supply_and_demand->industry_id) {
            $supply_and_demand->industry_id = $request->industry_id;
        }
        if ($request->input('intro') && $request->intro != $supply_and_demand->intro) {
            $supply_and_demand->intro = $request->intro;
        }
        if ($request->input('start_time') && $request->start_time != $supply_and_demand->start_time) {
            $supply_and_demand->start_time = $request->start_time;
        }
        if ($request->input('end_time') && $request->end_time != $supply_and_demand->end_time) {
            $supply_and_demand->end_time = $request->end_time;
        }
        if ($request->input('linkman') && $request->linkman != $supply_and_demand->linkman) {
            $supply_and_demand->linkman = $request->linkman;
        }
        $supply_and_demand->save();
        return $this->success('ok', $supply_and_demand);
    }

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
     * 删除供需
     */
    public function deleteSupplyAndDemand(Request $request, SupplyAndDemand $supply_and_demand)
    {
        $supply_and_demand->delete();
        return $this->success('ok')
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

    public function industries(Request $request, Industry $industry)
    {
        $industries = $industry->orderBy('id', 'asc')->get();
        return $this->success('ok', $industries);
    }

    public function industry(Request $request, Industry $industry)
    {
        return $this->success('ok', $industry);
    }

    public function storeIndustry(Request $request, Industry $industry)
    {
        $name = $request->input('name');
        $industry->name = $name;
        $industry->save();
        return $this->success('ok', $industry);
    }

    public function updateIndustry(Request $request, Industry $industry)
    {
        if ($request->input("name") && $request->name != $industry->name) {
            $industry->name = $request->name;
        }
        $industry->save();
        return $this->success('ok', $industry);
    }

    public function deleteIndustry(Request $request, Industry $industry)
    {
        $industry->delete();
        return $this->success('ok');
    }
}

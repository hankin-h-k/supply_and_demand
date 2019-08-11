<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\Str;
use App\Models\Wechat;
use App\Models\User;
use App\Models\Collect;
use App\Models\SupplyAndDemand;
class UsersController extends Controller
{
	/**
	 * 我的简历
	 * @return [type] [description]
	 */
    public function user(Request $request)
    {
    	$user = auth()->user();
    	return $this->success('ok', $user);
    }

    /**
     * 更新微信信息
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updateWechat(Request $request)
    {
        $user = auth()->user();
        $user_info = $request->input('user_info');
        if (count($user_info)) {
            if (isset($user_info['nickName'])) {
                $user->name = $user_info['nickName'];
                $user->save();
                $user->wechat->nickname = $user->name;
            }
            if (isset($user_info['avatarUrl'])) {
                $user->wechat->avatar = $user_info['avatarUrl'];
            }
            $user->wechat->save();
        }
        return $this->success('ok');
    }

    /**
     * 修改头像
     */
    public function updateUserAvatar(Request $request)
    {
        $user = auth()->user();
        $avatar = $request->input('avatar');
        if (empty($avatar)) {
            return $this->failure('请上传头像');
        }
        $user->avatar = $avatar;
        $user->save();
        return $this->success('ok', $user);
    }

    /**
     * 我的收藏
     */
    public function myCollects(Request $request, Collect $collect)
    {
        $user = auth()->user();
        $status = $request->input('status', 'UNDERWAY');
        $type = $request->input('type','SUPPLY');
        $collects = $user->collects()->with('supply_and_demand')->whereHas('supply_and_demand', function($sql) use($status, $type){
            $sql->where('status', $status)->where('type', $type);
        })->orderBy('id', 'desc')->paginate();
        return $this->success('ok', $collects);
    }

    /**
     * 我的发布
     */
    public function userSupplyAndDemands(Request $request, SupplyAndDemand $supply_and_demand)
    {
        $user_id = auth()->id();
        $supply_and_demands = $supply_and_demand->where('user_id', $user_id);
        $type = $request->input('type');
        if ($type) {
            $$supply_and_demands = $supply_and_demands->where('type', $type);
        }
        $status = $request->input('status');
        if ($status) {
            $$supply_and_demands = $supply_and_demands->where('status', $status);
        }
        $supply_and_demands = $supply_and_demands->orderBy('id', 'desc')->paginate();
        foreach ($supply_and_demands as $supply_and_demand) {
            $supply_and_demand->pics = json_decode($supply_and_demand->pics, true);
        }
        return $this->success('ok', $supply_and_demands);
    }
}

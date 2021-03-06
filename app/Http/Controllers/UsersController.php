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
     * 修改用户信息
     * @param  request $request [description]
     * @return [type]           [description]
     */
    public function updateUser(Request $request)
    {
        $user = auth()->user();
        if ($request->input('name') && $request->name != $user->name) {
            $user->name = $request->name;
        }
        $user->save();
        return $this->success('ok', $user);
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
        // $status = $request->input('status', 'UNDERWAY');
        $type = $request->input('type','SUPPLY');
        $collects = $user->collects()->with('supply_and_demand')->whereHas('supply_and_demand', function($sql) use($type){
            $sql->where('type', $type);
        })->orderBy('id', 'desc')->paginate();
        foreach ($collects as $collect) {
            $collect->supply_and_demand->pics = json_decode($collect->supply_and_demand->pics, true);
        }
        return $this->success('ok', $collects);
    }

    /**
     * 我的发布
     */
    public function userSupplyAndDemands(Request $request, SupplyAndDemand $supply_and_demand)
    {
        $user_id = auth()->id();
        $type = $request->input('type');
        $status = $request->input('status');
        $supply_and_demands = SupplyAndDemand::where('user_id', $user_id)->where(function($sql) use($type, $status){
            if ($type) {
                $sql = $sql->where('type', $type);
            }
            if ($status) {
                $sql = $sql->where('status', $status);
            }
        });
        
        $supply_and_demands = $supply_and_demands->orderBy('id', 'desc')->paginate();
        foreach ($supply_and_demands as $supply_and_demand) {
            $supply_and_demand->pics = json_decode($supply_and_demand->pics, true);
        }
        return $this->success('ok', $supply_and_demands);
    }
}

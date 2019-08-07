<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplyAndDemand extends Model
{
	protected $fillable = [];
    protected $guarded = [];

    public function industry()
    {
    	return $this->hasOne(Industry::class, 'id', 'industry_id');
    }

    public function user()
    {
    	return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function top()
    {
        if ($this->is_top) {//已经是置顶状态
            //当前置顶以上的置顶状态-1
            SupplyAndDemand::where('is_top', '>', $this->is_top)->decrement('is_top', 1);
        }
		//置顶数
        $top_count = SupplyAndDemand::where('is_top', '>', 0)->where('id', '<>', $this->id)->count();
        $top_count = $top_count?$top_count:0;
        $this->is_top = $top_count + 1;
        $this->save();
        return ;
    }

    public function cancelTop()
    {
    	if ($this->is_top) {//已经是置顶状态
            //当前置顶以上的置顶状态-1
            SupplyAndDemand::where('is_top', '>', $this->is_top)->decrement('is_top', 1);
            $this->is_top = 0;
            $this->save();
        }
        return;
    }
}

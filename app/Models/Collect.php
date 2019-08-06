<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collect extends Model
{
    protected $fillable = [];
    protected $guarded = [];

    public function supply_and_demand()
    {
    	return $this->hasOne(SupplyAndDemand::class, 'id', 'supply_and_demand_id');
    }
}

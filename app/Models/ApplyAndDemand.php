<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplyAndDemand extends Model
{
    public function industry()
    {
    	return $this->hasOne(Industry::class);
    }
}

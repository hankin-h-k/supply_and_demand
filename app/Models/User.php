<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function collect($supply_and_demand)
    {
        $collect = $this->collects()->where('supply_and_demand_id', $supply_and_demand->id)->first();
        if ($collect) {
            $collect->delete();
        }else{
            $this->collects()->create(['supply_and_demand_id'=>$supply_and_demand->id]);
        }
        return;
    }

    public function wechat()
    {
        return $this->hasOne(Wechat::class);
    }
    public function collects()
    {
        return $this->hasMany(Collect::class);
    }

    public function isCollected($supply_and_demand)
    {
        $is_collected = $this->collects()->where('supply_and_demand_id', $supply_and_demand->id)->first();
        return $is_collected?1:0;
    }
}

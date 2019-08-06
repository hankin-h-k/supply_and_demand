<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\SupplyAndDemand;
use Faker\Generator as Faker;

$factory->define(SupplyAndDemand::class, function ($faker) {
    $pics = [
        'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1565117566244&di=e300f5ebf6f420e626979be679207a3d&imgtype=0&src=http%3A%2F%2Ffile05.16sucai.com%2F2015%2F0619%2Fe0eec759382c8861c31cd0d1339e1be7.jpg',
        'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1565117566244&di=e300f5ebf6f420e626979be679207a3d&imgtype=0&src=http%3A%2F%2Ffile05.16sucai.com%2F2015%2F0619%2Fe0eec759382c8861c31cd0d1339e1be7.jpg',
        'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1565117566244&di=e300f5ebf6f420e626979be679207a3d&imgtype=0&src=http%3A%2F%2Ffile05.16sucai.com%2F2015%2F0619%2Fe0eec759382c8861c31cd0d1339e1be7.jpg'
    ];
    $industry_index = random_int(1,5);
    return [
        'user_id'=>1,
        'is_top'=>0,
        'type'=>array_random(['SUPPLY', 'DEMAND']),
        'pics'=>json_encode($pics),
        'title'=> $faker->jobTitle,
        'industry_id'=>$industry_index,
        'province'=>$faker->state,
        'city'=>$faker->city,
        'start_time'=>date('Y-m-d H:i:s'),
        'end_time'=>date('Y-m-d H:i:s', strtotime('+1 day')),
        'content'=>$faker->text($maxNbChars = 200),
        'linkman'=>$faker->name,
        'link_mobile'=>$faker->phoneNumber,
        'link_wechat'=>$faker->phoneNumber,
        'link_email'=>'776514652@qq.com',
        'status'=>array_random(['FINISHED', 'UNDERWAY', 'UNPLAY', 'CANCELED']),
    ];
});

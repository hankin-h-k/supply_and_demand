<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;
use App\Models\Article;
use App\Models\Address;
use App\Models\SupplyAndDemand;
use App\Models\Info;
use App\Models\Industry;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home(Request $request, Ad $ad, Article $article, SupplyAndDemand $supply_and_demand)
    {
        //广告列表
        $ads = $ad->all();
        //文章
        $articles = $article->all();
        //推荐兼职
        $type = $request->input('type', 'SUPPLY');
        $supply_and_demands = $supply_and_demand->where('is_recommend', 1)->where('type', $type)->where('status', 'UNDERWAY')->paginate();
        foreach ($supply_and_demands as $supply_and_demand) {
            $supply_and_demand->pics = json_decode($supply_and_demand->pics, true);
        }
        return $this->success('ok', compact('ads', 'articles', 'supply_and_demands'));
    }

    /**
     * 联系信息
     */
    public function linInfo(Request $request, Info $info)
    {
        $info = $info->orderBy('id', 'desc')->first();
        return $this->success('ok', $info);
    }
    /**
     * 地址
     * @param  Request $request [description]
     * @param  Address $address [description]
     * @return [type]           [description]
     */
    public function addresses(Request $request, Address $address)
    {
        $addresses = $address->where('parent_id', 0)->get();
        foreach ($addresses as $address_obj) {
            $sub_addresses = $address->where('parent_id', $address_obj->id)->get();
            $address_obj->sub_addresses = $sub_addresses;
        }
        return $this->success('ok', $addresses);
    }

    /**
     * 文章列表
     * @param  Request $request [description]
     * @param  Article $article [description]
     * @return [type]           [description]
     */
    public function articles(Request $request, Article $article)
    {
        $articles = $article->orderBy('id', 'desc');
        $keyword = $request->input('keyword');
        if ($keyword) {
            $keyword = trim($keyword);
            $articles = $articles->where('title', 'like', '%'.$keyword.'%');
        }
        $articles = $articles->paginate();
        return $this->success('ok', $articles);
    }


    public function article(Request $request, Article $article)
    {
        return $this->success('ok', $article);
    }

    public function industries(Request $request, Industry $industry)
    {
        return $this->success('ok', $industry->all());
    }
}

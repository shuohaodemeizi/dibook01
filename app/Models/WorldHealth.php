<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class WorldHealth
{
//    protected $table='product_categorys';
//
//    protected $connection = 'mysql';
//
//    public $timestamps = false;

    //public $hidden = ['created_at','updated_at'];

    public static function getCache()
    {
        $cache = 1;
        //$t1 = Carbon::now()->timestamp;
        $comfunc = function()use(&$cache){

            $cache = 0;

            $arr = [
                ['cp'=>'76.4(男75.0\女77.9)','data_name'=>'预期寿命（岁）'],
                ['cp'=>'68.7','data_name'=>'健康预期寿命（岁）'],
                ['cp'=>'27','data_name'=>'孕产妇死亡率（/10万活产）'],
                ['cp'=>'9.9','data_name'=>'5岁一下儿童死亡率（/1000活产）'],
                ['cp'=>'5.1','data_name'=>'新生儿死亡率（/1000活产）'],
                ['cp'=>'64','data_name'=>'结核发生率（/10万活产）'],
                ['cp'=>'17.0','data_name'=>'30-70岁死于CVD、癌症、糖尿病和CRD的可能性（%）'],
                ['cp'=>'9.7','data_name'=>'自杀死亡率（/10万人）'],
                ['cp'=>'18.8','data_name'=>'道路交通死亡率（/10万人）'],
                ['cp'=>'9.2','data_name'=>'青少年生育率（1000的15-19岁女性）'],
                ['cp'=>'112.7','data_name'=>'归因于室内和大气污染的死亡率（/10万人）'],
                ['cp'=>'1.4','data_name'=>'归因于无意中毒的死亡率（/10万人）'],
                ['cp'=>'男性48.4,女性1.9','data_name'=>'>14岁人群的年龄标化吸烟率'],
                ['cp'=>'0.9','data_name'=>'凶杀所致死亡（/10万人）'],
            ];

            return $arr;
        };

        $arr = Cache::remember('WorldHealrh', 1, $comfunc);

        $remark ='注：除特别注明时间外，均为2016年数据。孕产妇死亡率，2015年；道路交通死 亡率，2013年；青少年生育率，2007-2016年';
        $source = '来源：World Health Statistics 2018: Monitoring health for the SDGs. WHO. 6 June 2018.';
        return [$arr,$cache,$remark,$source];
    }

}

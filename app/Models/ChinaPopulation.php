<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ChinaPopulation
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
            $url = 'https://countrymeters.info/cn/China/';
            $obj = \QL\QueryList::get($url);//不需要用到js渲染
            $obj->rules([
                'cp' => ['.counter>div','text'],
                'data_name' => ['.data_name','text']
            ]);
            $arr = $obj->queryData();

            return $arr;
        };

        $arr = Cache::remember('chinaPopulation', 1, $comfunc);

        return [$arr,$cache];
    }

}

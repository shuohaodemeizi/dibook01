<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TsLunyu extends Model
{
    protected $table='lunyu';

    protected $connection = 'mysql_ts300';

    public $timestamps = false;

    //public $hidden = ['created_at','updated_at'];

    public function generateNickname($search)
    {
        $num = $search['num'];
        //$maxid = TsLunyu::orderby('id','DESC')->pluck('id')->first();
        // 有一个脚本，把这些都跑出来在一个库里面，
        // 之后再随机获取
        // 现在 先取后逻辑 , 一句歌词，7个字
        $list = self::whereRaw("id >= (select floor(max(id)*RAND()) from {$this->table})")->limit($num)->get();
        foreach ($list as $k=>$info) {
            preg_match_all('/[\x{4e00}-\x{9fa5}]+/u', $info->content,$nickname);

            $nickname = array_where($nickname[0],function ($v){
                if(stripos((string)$v,'曰')===false){
                    return $v;
                }
            });
            $nickname = array_values($nickname);//关联数组变序列数组
            //$nickname = array_map(function ($v){return $v.'2'; },$nickname);
            $nickname = $nickname[rand(0,count($nickname)-1)];


            $res[] = ['nickname'=>$nickname,'chapter'=>'《'.$info->chapter.'》'];

        }
        return $res;
    }

}

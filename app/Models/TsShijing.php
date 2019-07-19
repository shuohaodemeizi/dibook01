<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TsShijing extends Model
{
    protected $table='shijing';

    protected $connection = 'mysql_ts300';

    public $timestamps = false;

    //public $hidden = ['created_at','updated_at'];

    public function generateNickname($num)
    {
        $list = self::whereRaw("id >= (select floor(max(id)*RAND()) from {$this->table})")->limit($num)->get();
        foreach ($list as $k=>$info) {
            preg_match_all('/[\x{4e00}-\x{9fa5}]+/u', $info->content,$nickname);
            if(empty($nickname)) continue;
            $nickname = array_where($nickname[0],function ($v){
                if(stripos((string)$v,'曰')===false){
                    return $v;
                }
            });
            $nickname = array_values($nickname);//关联数组变序列数组
            if(empty($nickname)) continue;
            $nickname = $nickname[rand(0,count($nickname)-1)];
            $res[] = ['nickname'=>$nickname,'chapter'=>'《'.$info->chapter.'》'];
        }
        return $res;
    }
}

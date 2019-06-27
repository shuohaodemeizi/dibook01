<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Garbages extends Model
{
    protected $table='garbages';

    protected $connection = 'mysql_garbage';

    public $timestamps = true;

    //public $hidden = ['created_at','updated_at'];
    public static $type_array = ['wait'=>'待定',
        'recyclable'=>'可回收',
        'hazardous'=>'有害',
        'householdfood'=>'湿垃圾',
        'residual'=>'干垃圾'];

    public static $is_show_array = [
        '1' => ['value' => 1, 'text' => '打开', 'color' => 'success'],
        '0' => ['value' => 0, 'text' => '关闭', 'color' => 'danger'],
    ];

    public function parent()
    {
        return $this->belongsTo("App\Models\Garbages",'pid','id');
    }



}

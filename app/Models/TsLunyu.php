<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TsLunyu extends Model
{
    protected $table='lunyu';

    protected $connection = 'mysql_ts300';

    public $timestamps = false;

    //public $hidden = ['created_at','updated_at'];

    public function generateNickname($num)
    {
        $maxid = TsLunyu::orderby('id','DESC')->pluck('id')->first();




        return $maxid;
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TsShijing extends Model
{
    protected $table='shijing';

    protected $connection = 'mysql_ts300';

    public $timestamps = false;

    //public $hidden = ['created_at','updated_at'];

}

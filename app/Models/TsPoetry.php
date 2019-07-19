<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TsPoetry extends Model
{
    protected $table='poetry';

    protected $connection = 'mysql_ts300';

    public $timestamps = false;

    //public $hidden = ['created_at','updated_at'];

}

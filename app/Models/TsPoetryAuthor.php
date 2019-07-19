<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TsPoetryAuthor extends Model
{
    protected $table='poetry_author';

    protected $connection = 'mysql_ts300';

    public $timestamps = false;

    //public $hidden = ['created_at','updated_at'];

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TsPoemsAuthor extends Model
{
    protected $table='poems_author';

    protected $connection = 'mysql_ts300';

    public $timestamps = false;

    //public $hidden = ['created_at','updated_at'];

}

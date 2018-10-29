<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableDataDate extends Model
{
    protected $table='table_data_date';

    protected $connection = 'mysql';

    public $timestamps = true;

    //public $hidden = ['created_at','updated_at'];

}

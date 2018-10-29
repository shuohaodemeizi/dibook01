<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableDataDateitem extends Model
{
    protected $table='table_data_dateitem';

    protected $connection = 'mysql';

    public $timestamps = true;

    //public $hidden = ['created_at','updated_at'];

}

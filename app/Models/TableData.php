<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableData extends Model
{
    protected $table='table_data';

    protected $connection = 'mysql';

    public $timestamps = true;

    public $hidden = ['created_at','updated_at'];

}

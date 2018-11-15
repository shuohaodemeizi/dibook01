<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductItems extends Model
{
    protected $table='product_items';

    protected $connection = 'mysql';

    public $timestamps = false;

    //public $hidden = ['created_at','updated_at'];

}

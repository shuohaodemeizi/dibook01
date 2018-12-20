<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductToProduct extends Model
{
    protected $table='product_to_product';

    protected $connection = 'mysql';

    public $timestamps = false;

    //public $hidden = ['created_at','updated_at'];

}

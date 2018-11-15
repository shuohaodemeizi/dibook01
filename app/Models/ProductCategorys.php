<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategorys extends Model
{
    protected $table='product_categorys';

    protected $connection = 'mysql';

    public $timestamps = false;

    //public $hidden = ['created_at','updated_at'];

}

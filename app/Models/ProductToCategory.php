<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductToCategory extends Model
{
    protected $table='product_to_category';

    protected $connection = 'mysql';

    public $timestamps = false;

    //public $hidden = ['created_at','updated_at'];

}

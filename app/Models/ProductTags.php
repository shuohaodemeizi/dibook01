<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTags extends Model
{
    protected $table='product_tags';

    protected $connection = 'mysql';

    public $timestamps = false;

    //public $hidden = ['created_at','updated_at'];

}

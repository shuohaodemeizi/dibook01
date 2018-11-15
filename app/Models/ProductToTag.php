<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductToTag extends Model
{
    protected $table='product_to_tag';

    protected $connection = 'mysql';

    public $timestamps = true;

    //public $hidden = ['created_at','updated_at'];

}

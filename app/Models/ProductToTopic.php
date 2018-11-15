<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductToTopic extends Model
{
    protected $table='product_to_topic';

    protected $connection = 'mysql';

    public $timestamps = true;

    //public $hidden = ['created_at','updated_at'];

}

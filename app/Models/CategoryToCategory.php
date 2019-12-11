<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryToCategory extends Model
{
    protected $table='category_to_category';

    protected $connection = 'mysql';

    public $timestamps = false;

    //public $hidden = ['created_at','updated_at'];

}

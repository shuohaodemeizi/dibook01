<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table='products';

    protected $connection = 'mysql';

    public $timestamps = true;

    //public $hidden = ['created_at','updated_at'];

    public function categorys()
    {
        return $this->belongsToMany("App\Models\ProductCategorys",'product_to_category','product_id','category_id','id','id');

    }
    public function tags()
    {
        return $this->belongsToMany("App\Models\ProductTags",'product_to_tag','product_id','tag_id','id','id');

    }

}

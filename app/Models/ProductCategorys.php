<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategorys extends Model
{
    protected $table='product_categorys';

    protected $connection = 'mysql';

    public $timestamps = false;

    //public $hidden = ['created_at','updated_at'];

    public function products()
    {
        return $this->belongsToMany("App\Models\Products",'product_to_category','category_id','product_id','id','id');

    }

    public function categorys(){
        return $this->hasMany("App\Models\ProductCategorys",'pid','id')->with('products');
    }

}

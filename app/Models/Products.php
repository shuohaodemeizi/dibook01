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

    // 相关文章
    public function products()
    {
        return $this->belongsToMany("App\Models\Products",'product_to_product','product_id','to_product_id','id','id');

    }
    public function setImagesAttribute($images)
    {
        if (is_array($images)) {
            $this->attributes['images'] = json_encode($images);
        }
    }

    public function getImagesAttribute($images)
    {
        return json_decode($images, true);
    }


}

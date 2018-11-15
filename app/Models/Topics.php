<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topics extends Model
{
    protected $table='topics';

    protected $connection = 'mysql';

    public $timestamps = true;

    //public $hidden = ['created_at','updated_at'];

    public function products()
    {
        return $this->belongsToMany("App\Models\Products",'product_to_topic','product_id','topic_id','id','id');

    }

}

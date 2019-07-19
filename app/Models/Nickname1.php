<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Nickname1 extends Model
{
    protected $table='nickname';

    protected $connection = 'mysql_garbage';

    public $timestamps = true;

    public function generateNickname($num)
    {
        $jsonstr1 = file_get_contents(storage_path('nickname_generator/adjective.json'));
        $jsonstr2 = file_get_contents(storage_path('nickname_generator/noun.json'));
        $json1 = json_decode($jsonstr1);
        $json2 = json_decode($jsonstr2);

        $nickname = [];
        $count1 = count($json1);
        $count2 = count($json2);

        for ($i = 0; $i < $num; $i++) {
            $nickname[] = $json1[rand(0,$count1)] . '的' .$json2[rand(0,$count2)];
        }

        return $nickname;
    }

}

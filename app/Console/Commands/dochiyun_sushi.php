<?php

namespace App\Console\Commands;

use App\Models\ProductItems;
use App\Models\Topics;
use App\Models\TsPoems;
use Carbon\Carbon;
use Faker\Provider\File;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use QL\QueryList;
use JonnyW\PhantomJs\Client;

class dochiyun_sushi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:dochiyun';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'dochiyun,再storage生成 doyuntu-sushi.py';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        TsPoems::where('author_id',1)
            //->limit(10)
            ->chunk(100, function ($list100)  {
                $str = '';
                echo count($list100);
                foreach ($list100 as $info){
                    //$str = $str .$info->content;
                    $a =  Storage::disk('storage')->append('/chinese-poetry/doyuntu_sushi.txt',$info->content);
                    var_dump($a);
                }

                return true;
            });


    }



}

<?php

namespace App\Console\Commands;

use App\Models\ProductItems;
use App\Models\Topics;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use QL\QueryList;
use JonnyW\PhantomJs\Client;

class ChinaPopulation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:chinaPopulation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '每分钟执行到redis里面';

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
        $cache = 1;
        $comfunc = function()use(&$cache){

            $t1 = Carbon::now()->timestamp;
            $cache = 0;
            $url = 'https://countrymeters.info/cn/China/';
            $obj = \QL\QueryList::get($url);//不需要用到js渲染
            $obj->rules([
                'cp' => ['.counter>div','text'],
                'data_name' => ['.data_name','text']
            ]);
            $arr = $obj->queryData();

            return [$arr,$t1];
        };

        list($arr,$t1) = Cache::remember('chinaPopulation', 1, $comfunc);

        echo "cache={$cache} ,count=".count($arr);

    }
}

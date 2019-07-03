<?php

namespace App\Console\Commands;

use App\Models\Garbages;
use App\Models\ProductItems;
use App\Models\Topics;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use QL\QueryList;
use JonnyW\PhantomJs\Client;

class InsertWaste extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:insertWaste';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '导入元数据垃圾分类';

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
        // $typeArray = ['recyclable','hazardous','householdfood','residual'];

        $arrT['recyclable']['废纸'] = "报纸、期刊、图书、各种包装纸";
        $arrT['recyclable']['塑料'] = "塑料袋、塑料泡沫、塑料包装、一次性塑料餐盒餐具、硬塑料、塑料牙刷、塑料杯子、矿泉水瓶";
        $arrT['recyclable']['玻璃'] = "玻璃瓶、碎玻璃片、镜子、暖瓶";
        $arrT['recyclable']['金属物'] = "易拉罐、罐头盒";
        $arrT['recyclable']['布料'] = "废弃衣服、桌布、洗脸巾、书包、鞋";
        $arrT['householdfood'][''] = "剩菜剩饭、骨头、菜根菜叶、果皮等食品类废物、玉米核、坚果壳、果核、鸡骨、废弃食用油、残枝落叶、开败的鲜花";
        $arrT['residual'][''] = "砖瓦陶瓷、渣土、卫生间废纸、纸巾、果壳、尘土、大棒骨、厕纸、卫生纸";
        $arrT['hazardous'][''] = "电池、荧光灯管、灯泡、水银温度计、油漆桶、部分家电、过期药品、过期化妆品";


        $arrT['householdfood'][''] = '鸡蛋、鸡蛋壳、蛋壳';

        //发现生活种1000种物品
        // 词典：http://xh.5156edu.com/html/326.html

        foreach ($arrT as $type => $arr) {
            foreach ($arr as $k => $v) {
                $pid = Garbages::where('name',$k)->pluck('id')->first();
                if (empty($pid)) {
                    if(!Garbages::where('name',$k)->exists() && $k){
                        $obj = new Garbages();
                        $obj->name = $k;
                        $obj->type = $type;
                        $obj->pid = 0;
                        $obj->save();
                        $pid = $obj->id;
                    }
                }

                $tmpArr = explode('、',$v);
                foreach ($tmpArr as $kk => $vv) {
                    if(!Garbages::where('name',$vv)->exists()) {
                        $obj = new Garbages();
                        $obj->name = $vv;
                        $obj->type = $type;
                        $obj->pid = (int)$pid;
                        $obj->save();
                    }
                }
            }
        }


    }
}

<?php

namespace App\Console\Commands;

use App\Models\ProductItems;
use App\Models\Topics;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use QL\QueryList;
use JonnyW\PhantomJs\Client;

class doiphone7 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:iphonexr64';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '每天执行采集iphone的价格';

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
        $topic = Topics::with(['products'=>function($query){
            //$query->select(['id','name','url']);
        }])
            ->find(1);

        $td = Carbon::now()->toDateString();

        foreach ($topic->products as $product)
        {
            if (!ProductItems::where('product_id', $product->id)->where('date', $td)->exists())
            {
                $price = self::getPrice($product->url ,$product->name);
                if(is_array($price) ){
                    $pi = new ProductItems();
                    $pi->product_id = $product->id;
                    $pi->date = $td;
                    $pi->number = intval(str_replace(['¥','HK','$',','],'',$price[0]['price']));
                    $pi->save();
                }else{
                    echo 'price';
                    var_dump($price);
                }
            }
        }
        return true;
    }

    public static function getPrice($url, $name='')
    {
        if(empty($url)) return ;

        switch ($url) {
            case strpos($url,'jd.com')!==false:
                $obj = \QL\QueryList::get($url);//不需要用到js渲染
                $obj->rules([
                    'price' => ['#priceSale','text']
                ]);
                break;

            case strpos($url,'suning.com')!==false:
/*                $html = file_get_contents('github.html');
                $data = QueryList::setHtml($html)
                    ->find('img')->attrs('src');
                print_r($data->all());*/
                $html = self::getHtmlUseJs($url);if(is_numeric($html))return;
                $html = '<html>'.$html.'<html>';// 苏宁奇怪的没有html //var_dump(substr($html,0,1000));//$html = file_get_contents('xr55.html');
                $obj = QueryList::setHtml($html);
                $price = $obj->find('#juprice')->texts();

                $r[0]['price'] = $price[0];//和rules一样的格式输出
                return $r;
                break;
            case strpos($url,'apple.com')!==false:
                // 代理没处理，只能在服务上请求
                $html = self::getHtmlUseJs($url);
                //file_put_contents('apple.html',$html);
                //$html = file_get_contents('apple.html');
                $obj = QueryList::setHtml($html);if(is_numeric($html))return;
                $prices = $obj->find('.price-point-fullPrice-short')->texts()->toArray();
                $gbs = $obj->find('.as-dimension-capacity-text')->texts()->toArray();
                foreach ($gbs as $k=>$gb) {
                    $tmpgb = intval($gb);
                    if (strpos($name, (string)$tmpgb) !== false) {//em.iphoneXR(64g)香港  ,64 strpos 不能比较字符串和数字
                        $r[0]['price'] = $prices[$k];
                        return $r;
                    }
                }

                return 'err:页面元素变动';
                break;
            default:
                return 22;
        }
        //return $obj->queryData();//V4.0.4版本新增了一个queryData()语法糖来简化这种操作:
        return $obj->query()->getData()->toArray();//就版本4.00才是
    }

    public static function getHtmlUseJs($url)
    {
        $client = Client::getInstance();

        $request  = $client->getMessageFactory()->createRequest();
        $response = $client->getMessageFactory()->createResponse();

        $request->setMethod('GET');
        $request->setUrl($url);

        $client->send($request, $response);

        if($response->getStatus() === 200) {
            return $response->getContent();
            var_dump($response->getContent());// $response->getContent();
        }else{
            return $response->getStatus();
            //die();
        }
    }

}

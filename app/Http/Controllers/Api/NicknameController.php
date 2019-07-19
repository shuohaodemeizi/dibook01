<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\ChinaPopulation;
use App\Models\Garbages;
use App\Models\Nickname1;
use App\Models\ProductCategorys;
use App\Models\Products;
use App\Models\WorldHealth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class NicknameController extends Controller
{
    /**
     * @SWG\Post(
     *  tags={"MOBILE-garbages"},
     *  path="/api/nickname",
     *  summary="随机昵称type=1形容词+名称",
     *  @SWG\Parameter(
     *      in="query",
     *      name="type",
     *      description="1",
     *      type="string",
     *      default="",
     *  ),
     *  @SWG\Response(
     *      response=200,
     *      description="返回内容",
     *  )
     * )
     */
    public function index(Request $request)
    {
        $type = $request->input('type', '1');
        $page = $request->input('page',1);
        $limit = $request->input('limit',20);
        $offset = ($page-1)* $limit;

        $typeobj = [
            '1'=>'App\Models\Nickname1', //形容+名称
            '2'=>'App\Models\TsLunyu', //论语
            '3'=>'App\Models\TsPoems', //唐诗
            '4'=>'App\Models\TsPoetry',
        ];

        $classname = $typeobj[$type];
        $obj = new $classname();
        $list = $obj->generateNickname($num = 10);

        return $this->mobile_response(200,['list'=>$list],'随机昵称');
    }

}

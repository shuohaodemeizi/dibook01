<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\ChinaPopulation;
use App\Models\Garbages;
use App\Models\ProductCategorys;
use App\Models\Products;
use App\Models\WorldHealth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class GarbagesController extends Controller
{
    /**
     * @SWG\Post(
     *  tags={"MOBILE-garbages"},
     *  path="/api/garbages",
     *  summary="搜索某个文字",
     *  @SWG\Parameter(
     *      in="query",
     *      name="q",
     *      description="必须关键词",
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
        $q = $request->input('q', '');
        $pid =$request->input('pid', '');
        $page = $request->input('page',1);
        $limit = $request->input('limit',20);
        $offset = ($page-1)* $limit;

        if ($pid) {
            $list = Garbages::where('pid',$pid)->offset($offset)->limit($limit)->get();
        }else{
            $list = Garbages::where('name','like',"%$q%")->offset($offset)->limit($limit)->get();
        }

        return $this->mobile_response(200,['list'=>$list],'物品归类');
    }

    /**
     * @SWG\Post(
     *  tags={"MOBILE-garbages"},
     *  path="/api/garbages/hot",
     *  summary="搜索某个文字",
     *  @SWG\Response(
     *      response=200,
     *      description="返回热门关键词内容",
     *  )
     * )
     */
    public function hot(Request $request)
    {
        $list = Garbages::orderBy('hot','DESC')->limit(10)->get();
        return $this->mobile_response(200,['list'=>$list],'热门词');
    }
}

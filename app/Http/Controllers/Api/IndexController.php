<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\ChinaPopulation;
use App\Models\ProductCategorys;
use App\Models\Products;
use App\Models\WorldHealth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class IndexController extends Controller
{
    // 丢弃
    public function index(Request $request)
    {
        list($chinaPopulation,$cache) = ChinaPopulation::getCache();
        list($worldHealth,$cache,$remark,$source) = WorldHealth::getCache();//世界卫生组织



        return $this->mobile_response(200,[
            'chinaPopulation'=> $chinaPopulation,
            'worldHealth'=>['list'=>$worldHealth,'remark'=>$remark,'source'=>$source]
        ],'首页');
    }

    public function pcode(Request $request)
    {
        $pcode = $request->input('pcode');
        if (in_array($pcode, ['ChinaPopulation', 'WorldHealth']))
        {
            list($data,$cache,$remark,$source) = call_user_func("App\\Models\\{$pcode}::getCache"); //::getCache();
            $arr["{$pcode}"] = ['list'=>$data,'remark'=>$remark,'source'=>$source,'cache'=>$cache];
        }
        return $this->mobile_response(200,$arr,'pcode');
    }

    // 首页
    public function indexView(Request $request)
    {
        return $this->categoryView($request,1);
    }

    public function category(Request $request, $category_id)
    {
        return $this->categoryView($request,$category_id);
    }

    public function categoryView(Request $request, $category_id)
    {
        $validations = [
            'product_term_id' => 'integer|nullable',//required|string|max:64,
            'limit' => 'integer|max:20|min:1|nullable',//required|string|max:64,
            'page' => 'integer|min:1|nullable',//required|string|max:64,
        ];
        $validator = Validator::make($request->all(),$validations);
        if ($validator->fails()) {
            return $this->mobile_response(4010, [], $validator->errors()->first());
        }

        $user = $request->verifyUser;
        $user_id = isset($user->id)?$user->id:0;

        $this ->validate($request, $validations);
        $data = $request ->only(array_keys($validations));
        $limit = isset($data['limit'])?$data['limit']:20;
        $page = isset($data['page'])?$data['page']:1;
        $offset = ($page-1) * $limit;
        $category_id = $category_id<1?1:$category_id;

        $list = ProductCategorys::with('categorys')->with('products')->find($category_id);

        // $child_ids = ProductCategorys::where('pid',$category_id)->pluck('id')->toArray();
        //
        // //DB::connection()->enableQueryLog();
        // $list = Products::select('id','type','name','url','updated_at','callfunc')
        //     ->whereHas('categorys',function($query)use($child_ids){
        //         $query->select(['name'])->whereIn('product_to_category.category_id',$child_ids);
        //     })
        //     ->with(['tags'=>function($query){
        //         //$query->select(['name']);
        //     }])
        //     ->with('categorys')
        //
        //     ->where('is_show',1)
        //     ->orderBy('id','DESC')
        //     ->paginate(200);
        //var_dump($list->links());exit;
        //var_dump(DB::getQueryLog());
        $category = ProductCategorys::find($category_id);

        // 下拉框
        $common_categorys = ProductCategorys::where('is_show',1)->get();

        if ($request->input('format') == 'json') {
            return $this->mobile_response(200,['list'=>$list,'category'=>$category,'common_categorys'=>$common_categorys],'分类列表');
        }
        if ($category_id == 1) {
            return view('indexView',['list'=>$list,'category'=>$category,'common_categorys'=>$common_categorys]);
        }
        return view('categoryView',['list'=>$list,'category'=>$category,'common_categorys'=>$common_categorys]);
    }
    public function tagView(Request $request, $tag_id)
    {
        $validations = [
            'product_term_id' => 'integer|nullable',//required|string|max:64,
            'limit' => 'integer|max:20|min:1|nullable',//required|string|max:64,
            'page' => 'integer|min:1|nullable',//required|string|max:64,
        ];
        $validator = Validator::make($request->all(),$validations);
        if ($validator->fails()) {
            return $this->mobile_response(4010, [], $validator->errors()->first());
        }

        $user = $request->verifyUser;
        $user_id = isset($user->id)?$user->id:0;

        $this ->validate($request, $validations);
        $data = $request ->only(array_keys($validations));
        $limit = isset($data['limit'])?$data['limit']:20;
        $page = isset($data['page'])?$data['page']:1;
        $offset = ($page-1) * $limit;
        $tag_id = $tag_id<1?1:$tag_id;

        //DB::connection()->enableQueryLog();
        $list = Products::select('id','type','name','url','updated_at','callfunc')
            ->with(['categorys'=>function($query){
                //$query->select(['name']);
            }])
            ->whereHas('tags',function($query)use($tag_id){
                $query->where('product_to_tag.tag_id',$tag_id);
            })

            ->where('is_show',1)
            ->orderBy('id','DESC')
            ->paginate(5);

        $category = ProductCategorys::find($tag_id);
        //var_dump(DB::getQueryLog());
        // 下拉框
        $common_categorys = ProductCategorys::where('is_show',1)->get();

        if ($request->input('format') == 'json') {
            return $this->mobile_response(200,['list'=>$list,'category'=>$category,'common_categorys'=>$common_categorys],'标签列表');
        }
        return view('tagView',['list'=>$list,'category'=>$category,'common_categorys'=>$common_categorys]);
    }
    public function productView(Request $request, $product_id)
    {
        $product = Products::with(['categorys'=>function($query){
                //$query->select(DB::raw("name,product_categorys.id"));
                $query->where('product_to_category.category_id','!=',1);
            }])
            ->with(['tags'=>function($query){
                //$query->select(['name']);
            }])
            ->with(['products'=>function($query){
                //$query->select(['name']);
            }])
            ->find($product_id);
        // 上一篇|下一篇
        $pProduct=Products::where('id','<',$product->id)->where('is_show',1)->orderby('id','desc')->first();
        $nProduct=Products::where('id','>',$product->id)->where('is_show',1)->orderby('id','asc')->first();
        if (empty($product)) {
            return 404;
        }
        $temp = '';
        switch ($product->type) {
            case 'code':
                $temp = 'product'.ucfirst($product->type).$product->id;
                break;
            case 'article':
                $temp = 'product'.ucfirst($product->type);
                break;
            case 'link':
                return redirect("{$product->url}");
                break;
            default:
                dd($product);exit;
        }
        // 相关文章

        // 最新标签文章
        $groups = [];
        foreach ($product->categorys as $cat)
        {
            $tmp = Products::select('id','type','name','url','updated_at','callfunc')
                ->whereHas('categorys',function($query)use($cat){
                    $query->select(['name'])->where('product_to_category.category_id',$cat->id);
                })
                ->where('is_show',1)
                ->orderBy('id','DESC')
                ->paginate(3);
            $groups[] = [
                'info' =>$cat,
                'list' =>$tmp,
            ];
        }
       // dd($group);
        // 下拉框
        $common_categorys = ProductCategorys::where('is_show',1)->get();

        if ($request->input('format') == 'json') {
            return $this->mobile_response(200,['product'=>$product,'pProduct'=>$pProduct,'nProduct'=>$nProduct,'groups'=>$groups,'common_categorys'=>$common_categorys],'详情');
        }

        return view($temp,['product'=>$product,'pProduct'=>$pProduct,'nProduct'=>$nProduct,'groups'=>$groups,'common_categorys'=>$common_categorys]);
    }

    public function tag(Request $request, $tag_id)
    {
        $list = Products::where()->get();
        return $this->mobile_response(200,$list,'标签列表');
    }

    public function searchView(Request $request)
    {
        $kw = $request->input('kw');

        $list = Products::select('id','type','name','url','updated_at','callfunc')
            ->with(['categorys'=>function($query){
                //$query->select(['name']);
            }])
            ->with(['tags'=>function($query){
                //$query->select(['name']);
            }])
            ->where('is_show',1)
            ->where('name','like',"%{$kw}%")
            ->orderBy('id','DESC')
            ->paginate(5);

        $list->appends(['kw'=>$kw]);//非路由是参数需要，c/1；t/1不需要

        // 下拉框
        $common_categorys = ProductCategorys::where('is_show',1)->get();

        if ($request->input('format') == 'json') {
            return $this->mobile_response(200,['list'=>$list,'kw'=>$kw,'common_categorys'=>$common_categorys],'搜索列表');
        }
        return view('searchView',['list'=>$list,'kw'=>$kw,'common_categorys'=>$common_categorys]);
    }

    public function product(Request $request, $tag_id)
    {
        $info = Products::where()->get();
        return $this->mobile_response(200,$info,'详情');
    }


}

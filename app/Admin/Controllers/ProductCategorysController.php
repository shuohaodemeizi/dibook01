<?php

namespace App\Admin\Controllers;

use App\Models\ProductCategorys;
use App\Models\Products;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;



class ProductCategorysController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
//        $prod = Products::find(28);
//        $prod->categorys;
//        echo '<pre>';
//        var_dump($prod->toArray());exit;

        return Admin::content(function (Content $content) {

            $content->header('分类');
            $content->description('description');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('分类');
            $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('分类');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(ProductCategorys::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->name('名称');
            $grid->is_show('启用')->display(function ($is_show) {
                return $is_show==1? "<span class='label label-success'>启用中</span>":"<span class='label label-default'>已关闭</span>";
            });

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(ProductCategorys::class, function (Form $form) {
            $pc = ProductCategorys::select(['id','name'])->where('pid','=',0)->pluck('name', 'id');
            $form->display('id', 'ID');
            $form->text('name', '名称');
            $form->select('pid2','选择分类')->options($pc)->load('pid','/admin/get_categorys');
            $form->select('pid','选择子分类')->options(function($id){
                 return ProductCategorys::where('id',$id)->pluck('name', 'id');
            });

            $states = [
                '1' => ['value' => 1, 'text' => '打开', 'color' => 'success'],
                '0' => ['value' => 0, 'text' => '关闭', 'color' => 'danger'],
            ];

            $form->switch('is_show','开关')->states($states);
        });
    }

    /**
     * Create a function
     *
     * @param string $var
     * @return void
     */
    public function getCategorys(Request $request)
    {
      $q = $request->input('q',0);
      return ProductCategorys::select(DB::Raw("id,concat(name,'[',id,']') as name"))->whereRaw("(id={$q} or pid={$q})")->pluck('name', 'id');
    }
}

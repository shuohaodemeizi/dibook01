<?php

namespace App\Admin\Controllers;

use App\Models\Garbages;
use App\Models\ProductCategorys;
use App\Models\Products;
use App\Models\ProductTags;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\Facades\DB;


class GarbagesController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('物品归类');
            $content->description('可回收，有害，湿垃圾，干垃圾');

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

            $content->header('物品归类');
            $content->description('可回收，有害，湿垃圾，干垃圾');

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

            $content->header('物品归类');
            $content->description('可回收，有害，湿垃圾，干垃圾');

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
        return Admin::grid(Garbages::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->name('物品');
            $grid->type('归类')->display(function ($type) {
                return Garbages::$type_array[$type];
            });
            $grid->pid('父级')->display(function ($pid) {
                return $pid?Garbages::select(DB::raw("concat('[',id,']',name) as name"))->where('id',$pid)->pluck('name')->first():'--';
            });
            $grid->is_show('启用')->display(function ($is_show) {
                return $is_show==1? "<span class='label label-primary'>ON</span>":"<span class='label label-default'>OFF</span>";
            });

            $grid->created_at('创建时间');
            $grid->updated_at('修改时间');

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Garbages::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('name', '标题');
            $form->select('type','归类')->options(Garbages::$type_array);
            $form->select('pid','父级')->options(Garbages::all()->pluck('name', 'id'));
            $form->switch('is_show','开关')->default(1)->states(Garbages::$is_show_array);
            $form->dateTime('created_at', '创建时间');
            $form->dateTime('updated_at', '修改时间');
        });
    }
}

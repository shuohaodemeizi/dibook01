<?php

namespace App\Admin\Controllers;

use App\Models\Products;
use App\Models\Topics;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;



class TopicsController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
//        $prod = Topics::find(28);
//        $prod->categorys;
//        echo '<pre>';
//        var_dump($prod->toArray());exit;

        return Admin::content(function (Content $content) {

            $content->header('专题');
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

            $content->header('专题');
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

            $content->header('专题');
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
        return Admin::grid(Topics::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->name('专题名称');
            //$grid->tags('标签');

            $grid->products('拥有产品')->display(function ($categorys) {
                $categorys = array_map(function ($category) {
                    return "<span class='label label-success'>{$category['name']}</span>";
                }, $categorys);

                return join('&nbsp;', $categorys);
            });

            $grid->is_show('启用')->display(function ($is_show) {
                return $is_show==1? "<span class='label label-primary'>启用中</span>":"<span class='label label-default'>已关闭</span>";
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
        return Admin::form(Topics::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('name', '专题名称');
            //$form->text('tags', '标签');
            $form->dateTime('created_at', '创建时间');
            $form->dateTime('updated_at', '修改时间');
            // 可以多选下拉框
            $form->multipleSelect('products','拥有产品')->options(Products::all()->pluck('name', 'id'));

            $form->switch('is_show','开关')->states([
                '1' => ['value' => 1, 'text' => '打开', 'color' => 'success'],
                '0' => ['value' => 0, 'text' => '关闭', 'color' => 'danger'],
            ]);


        });
    }
}

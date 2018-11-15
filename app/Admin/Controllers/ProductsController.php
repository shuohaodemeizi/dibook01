<?php

namespace App\Admin\Controllers;

use App\Models\ProductCategorys;
use App\Models\Products;
use App\Models\ProductTags;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;



class ProductsController extends Controller
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

            $content->header('产品');
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

            $content->header('产品');
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

            $content->header('header');
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
        return Admin::grid(Products::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->name('标题');
            //$grid->tags('标签');

            $grid->categorys('所属分类')->display(function ($categorys) {
                $categorys = array_map(function ($category) {
                    return "<span class='label label-success'>{$category['name']}</span>";
                }, $categorys);

                return join('&nbsp;', $categorys);
            });

            $grid->tags('所属标签')->display(function ($tags) {
                $tags = array_map(function ($tag) {
                    return "<span class='label label-success'>{$tag['name']}</span>";
                }, $tags);

                return join('&nbsp;', $tags);
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
        return Admin::form(Products::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('name', '标题');
            //$form->text('tags', '标签');
            $form->dateTime('created_at', '创建时间');
            $form->dateTime('updated_at', '修改时间');
            // 可以多选下拉框
            $form->multipleSelect('categorys','分类')->options(ProductCategorys::all()->pluck('name', 'id'));
            $form->multipleSelect('tags','标签')->options(ProductTags::all()->pluck('name', 'id'));

            $states = [
                '1' => ['value' => 1, 'text' => '打开', 'color' => 'success'],
                '0' => ['value' => 0, 'text' => '关闭', 'color' => 'danger'],
            ];

            $form->switch('is_show','开关')->states($states);

            $form->textarea('fulltext','内容');

        });
    }
}

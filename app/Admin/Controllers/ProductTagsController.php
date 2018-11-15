<?php

namespace App\Admin\Controllers;

use App\Models\ProductTags;
use App\Models\Products;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;



class ProductTagsController extends Controller
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

            $content->header('标签');
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

            $content->header('标签');
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
        return Admin::grid(ProductTags::class, function (Grid $grid) {

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
        return Admin::form(ProductTags::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('name', '名称');
            $states = [
                '1' => ['value' => 1, 'text' => '打开', 'color' => 'success'],
                '0' => ['value' => 0, 'text' => '关闭', 'color' => 'danger'],
            ];

            $form->switch('is_show','开关')->states($states);
        });
    }
}

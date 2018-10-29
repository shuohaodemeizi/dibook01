<?php

namespace App\Admin\Controllers;

use App\Models\TableDataDateitem;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;



class TableDataDateitemController extends Controller
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

            $content->header('header');
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

            $content->header('header');
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
        return Admin::grid(TableDataDateitem::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->tdd_id('（外健）最新的一期');
            $grid->title('标题');

            $grid->f1();
            $grid->f2();
            $grid->f3();
            $grid->f4();
            $grid->f5();
            $grid->f6();
            $grid->f7();
            $grid->f8();
            $grid->f9();
            $grid->f10();


        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(TableDataDateitem::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->number('tdd_id', '用户ID');
            $form->text('title', '标题');

            $form->text('f1', 'f1');
            $form->text('f2', 'f2');
            $form->text('f3', 'f3');
            $form->text('f4', 'f4');
            $form->text('f5', 'f5');
            $form->text('f6', 'f6');
            $form->text('f7', 'f7');
            $form->text('f8', 'f8');
            $form->text('f9', 'f9');
            $form->text('f10', 'f10');

        });
    }
}

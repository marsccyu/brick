<?php

namespace App\Admin\Controllers;

use App\Models\About_us;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Content;

class AboutController extends AdminController
{
    protected $title = '關於工作室';

    public function index(Content $content)
    {
        $content->title('關於工作室');
        $content->description('"關於我們"聊天室視窗回覆訊息');

        $content->breadcrumb(
            ['text' => '關於我們', 'url' => '/about'],
        );
        $content->body($this->grid());
        return $content;
    }

    public function edit($id, Content $content)
    {
        return $content
            ->header('關於工作室')
            ->description('編輯聊天室視窗回覆訊息')
            ->breadcrumb(
                ['text' => '關於我們', 'url' => '/about'],
                ['text' => '編輯', 'url' => '/about/' . $id . '/edit']
            )->body($this->form()->edit($id));
    }

    protected function grid()
    {
        $grid = new Grid(new About_us());

        $grid->column('id', __('Id'));
        $grid->column('content', __('文字內容'));
        $grid->disableCreateButton();
        $grid->disablePagination();
        $grid->disableExport();
        $grid->disableFilter();
        $grid->disableRowSelector();
        $grid->disableCreateButton();
        $grid->disableColumnSelector();
        $grid->disableRowSelector();
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableDelete();
            $actions->disableView();
        });
        return $grid;
    }

    protected function form()
    {
        $form = new Form(new About_us());

        $form->textarea('content', __('文字內容'))->required();

        $form->tools(function (Form\Tools $tools) {
            // 去掉`删除`按钮
            $tools->disableDelete();
            // 去掉`查看`按钮
            $tools->disableView();
        });

        $form->footer(function ($footer) {
            // 去掉`重置`按钮
            $footer->disableReset();
            // 去掉`查看`checkbox
            $footer->disableViewCheck();
            // 去掉`继续编辑`checkbox
            $footer->disableEditingCheck();
            // 去掉`继续创建`checkbox
            $footer->disableCreatingCheck();
        });

        return $form;
    }
}

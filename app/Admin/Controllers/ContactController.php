<?php

namespace App\Admin\Controllers;

use App\Models\ContactUs;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Content;

class ContactController extends AdminController
{
    protected $title = '聯絡我們';

    public function index(Content $content)
    {
        $content->title('聯絡我們');
        $content->description('"聯絡我們"聊天室視窗回覆訊息');

        $content->breadcrumb(
            ['text' => '聯絡我們', 'url' => '/contactUs'],
        );
        $content->body($this->grid());
        return $content;
    }

    public function edit($id, Content $content)
    {
        return $content
            ->header('聯絡我們')
            ->description('編輯"聯絡我們"聊天室視窗回覆訊息')
            ->breadcrumb(
                ['text' => '聯絡我們', 'url' => '/contactUs'],
                ['text' => '編輯', 'url' => '/about/' . $id . '/edit']
            )->body($this->form($id)->edit($id));
    }

    protected function grid()
    {
        $grid = new Grid(new ContactUs());

        $grid->column('id', __('Id'));
        $grid->column('description', __('說明'));
        $grid->column('content', __('內容'));

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
        $form = new Form(new ContactUs());

        $form->tools(function (Form\Tools $tools) {
            // 去掉`删除`按钮
            $tools->disableDelete();
            // 去掉`查看`按钮
            $tools->disableView();
        });

        $form->text('description', __('說明'))->readonly();
        $form->textarea('content', __('內容'))->required();

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

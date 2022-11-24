<?php

namespace App\Admin\Controllers;

use App\Models\Course;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Content;

class CourseController extends AdminController
{
    protected $title = '期別資訊';

    public function index(Content $content)
    {
        $content->title('期別資訊');
        $content->description('課程期別清單');

        $content->breadcrumb(
            ['text' => '期別資訊', 'url' => '/course'],
        );
        $content->body($this->grid());
        return $content;
    }

    public function edit($id, Content $content)
    {
        return $content
            ->header('期別資訊')
            ->description('編輯期別名稱')
            ->breadcrumb(
                ['text' => '期別資訊', 'url' => '/course'],
                ['text' => '編輯', 'url' => '/course/' . $id . '/edit']
            )->body($this->form()->edit($id));
    }

    protected function grid()
    {
        $grid = new Grid(new Course());

        $grid->column('id', __('Id'));
        $grid->column('name', __('名稱'));
        $grid->column('created_at', __('建立時間'));

        $grid->disableCreateButton();
        $grid->disablePagination();
        $grid->disableExport();
        $grid->disableFilter();
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
        $form = new Form(new Course());

        $form->text('name', __('名稱'))->required();
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

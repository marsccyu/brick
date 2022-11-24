<?php

namespace App\Admin\Controllers;

use App\Models\Point_task;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Content;

class PointTaskController extends AdminController
{
    protected $title = '積分任務';

    public function index(Content $content)
    {
        $content->title('積分任務管理');
        $content->description('積分項目');

        $content->breadcrumb(
            ['text' => '積分任務管理', 'url' => '/point_tasks'],
        );
        $content->body($this->grid());
        return $content;
    }

    public function create(Content $content)
    {
        return $content
            ->header('積分任務管理')
            ->description('新增會員積分項目')
            ->breadcrumb(
                ['text' => '積分任務管理', 'url' => '/point_tasks'],
                ['text' => '新增', 'url' => '/point_tasks/create']
            )->body($this->form());
    }

    public function edit($id, Content $content)
    {
        return $content
            ->header('積分任務管理')
            ->description('編輯會員積分紀錄')
            ->breadcrumb(
                ['text' => '積分任務管理', 'url' => '/point_tasks'],
                ['text' => '編輯', 'url' => '/point_tasks/' . $id . '/edit']
            )->body($this->form()->edit($id));
    }

    protected function grid()
    {
        $grid = new Grid(new Point_task());

        $grid->column('id', __('Id'));
        $grid->column('name', __('任務鍵值'));
        $grid->column('description', __('說明'));
        $grid->column('point', __('增加或減少積分'));
        $grid->column('is_disabled', '狀態')->display(function ($value) {
            switch ($value) {
                case '1':
                    $text = '開啟';
                    $color = 'green';
                    break;
                case '0':
                default:
                    $text = '關閉';
                    $color = 'red';
                    break;
            }
            return "<span style='color:".$color."'>$text</span>";
        });
        $grid->disablePagination();
        $grid->disableExport();
        $grid->disableFilter();
        $grid->disableRowSelector();
//        $grid->disableCreateButton();
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
        $form = new Form(new Point_task());

        if ($id = request()->route()->parameter('id'))
        {
            $form->text('name', __('任務鍵值'))->readonly();
            $form->text('description', __('說明'))->required();
            $form->decimal('point', __('增加或減少積分'))->required();
            $form->switch('is_disabled', __('狀態'))->required();
        }
        else
        {
            $form->text('name', __('任務鍵值'))->placeholder('建議輸入英文或數字, 例: sign_in_lesson_5 ...')->required();
            $form->text('description', __('說明'))->required();
            $form->decimal('point', __('增加或減少積分'))->required();
            $form->switch('is_disabled', __('狀態'))->required();
        }

        $form->tools(function (Form\Tools $tools) {
            // 去掉`删除`按钮
//            $tools->disableDelete();
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

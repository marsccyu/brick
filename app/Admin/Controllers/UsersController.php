<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UsersController extends AdminController
{
    protected $title = '會員清單';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('Id'));
        $grid->column('type')->display(function ($value) {
            $type = match ($value) {
                'parents' => "家長",
                'student' => "學生",
            };
            return "<span style='color:blue'>$type</span>";
        });
        $grid->column('name', __('姓名'));
        $grid->column('user_id', __('User id'));
        $grid->column('email', __('Email'));
        $grid->column('telephone', __('電話'));
        $grid->column('created_at', __('加入時間'));
        $grid->disableCreateButton();

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableDelete();
            $actions->disableView();
        });
        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->tab('會員資料', function ($form) {
            $form->text('user_id', __('User id'))->readonly();
            $form->radio('type', '類型')->options(['parents' => '家長', 'student' => '學生'])->default('student');
            $form->text('name', __('姓名'));
            $form->email('email', __('Email'));
            $form->text('telephone', __('電話'));
            $form->text('age', __('年齡'))->readonly();
            $form->text('created_at', __('加入時間'))->readonly();

        })->tab('學習歷史', function ($form) {
            $form->text('age', __('年齡'))->readonly();
        })->tab('積分紀錄', function ($form) {
            $form->text('age', __('年齡'))->readonly();
        });

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

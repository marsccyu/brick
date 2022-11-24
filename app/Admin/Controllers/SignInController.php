<?php

namespace App\Admin\Controllers;

use App\Models\Classes;
use App\Models\SignIn;
use App\Models\Lesson;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Content;

class SignInController extends AdminController
{
    protected $title = '簽到管理';

    public function index(Content $content)
    {
        $content->title('簽到管理');
        $content->description('學生簽到清單');

        $content->breadcrumb(
            ['text' => '簽到管理', 'url' => '/sign_in'],
        );
        $content->body($this->grid());
        return $content;
    }

    protected function grid()
    {
        $grid = new Grid(new SignIn());

        $grid->column('id', __('Id'));
        $grid->column('lesson.title', __('課程名稱'));
        $grid->column('classes.id', __('課程編號'));
        $grid->column('classes.title', __('班級名稱'));
        $grid->column('user.id', __('會員編號'));
        $grid->column('user.name', __('會員名稱'));
        $grid->column('userId', __('User id'));
        $grid->column('created_at', __('簽到時間'));

        $grid->disableCreateButton();
        $grid->disablePagination();
        $grid->disableExport();
        $grid->disableColumnSelector();
        $grid->disableRowSelector();
//        $grid->disableActions();
        $grid->actions(function (Grid\Displayers\Actions $actions) {
//            $actions->disableDelete();
            $actions->disableView();
            $actions->disableEdit();
        });

        $grid->filter(function ($filter) {
            $filter->like('user_id', '會員編號');
        });
        return $grid;
    }

    protected function form()
    {
        $form = new Form(new SignIn());

        $form->select('lesson_id', __('課程名稱'))->options(Lesson::all()->pluck('title', 'id'));
        $form->select('classes_id', __('班級名稱'))->options(Classes::all()->pluck('title', 'id'));
        $form->text('user_id', __('會員編號'));
        $form->text('userId', __('User id'));

        return $form;
    }
}

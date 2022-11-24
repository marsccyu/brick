<?php

namespace App\Admin\Controllers;

use App\Models\Classes;
use App\Models\Course;
use App\Models\Lesson;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Content;

class ClassesController extends AdminController
{
    protected $title = '班級管理';

    public function index(Content $content)
    {
        $content->title('班級管理');
        $content->description('班級清單');

        $content->breadcrumb(
            ['text' => '班級管理', 'url' => '/classes'],
        );
        $content->body($this->grid());
        return $content;
    }

    public function create(Content $content)
    {
        return $content
            ->header('班級管理')
            ->description('新增班級')
            ->breadcrumb(
                ['text' => '班級管理', 'url' => '/classes'],
                ['text' => '新增', 'url' => '/classes/create']
            )->body($this->form());
    }

    public function edit($id, Content $content)
    {
        return $content
            ->header('班級管理')
            ->description('編輯課程資訊')
            ->breadcrumb(
                ['text' => '班級管理', 'url' => '/classes'],
                ['text' => '編輯', 'url' => '/classes/' . $id . '/edit']
            )->body($this->form()->edit($id));
    }

    protected function grid()
    {
        $grid = new Grid(new Classes());

        $grid->column('id', __('Id'));
        $grid->column('course_id', __('對應期別編號'));
        $grid->column('lesson_id', __('對應課程編號'));
        $grid->column('lesson.title', __('對應課程名稱'));
        $grid->column('title', __('名稱'));
        $grid->column('start', __('簽到開始時間'));
        $grid->column('end', __('簽到結束時間'));
//        $grid->disableCreateButton();
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
        $form = new Form(new Classes());

        if ($id = request()->route()->parameter('id'))
        {
            $form->text('lesson_id', __('對應課程編號'))->readonly();
            $form->text('lesson.title', __('對應課程名稱'))->readonly();
        }
        else
        {
            $form->select('course_id', '對應期別名稱')->options(Course::all()->pluck('name', 'id'))->required()
            ->when(1, function (Form $form)
            {
                $form->select('lesson_id', '課程名稱')->options(Lesson::where('course_id', 1)->get()->pluck('title', 'id'))->required();
            })->when(2, function (Form $form)
            {
                $form->select('lesson_id', '課程名稱')->options(Lesson::where('course_id', 2)->get()->pluck('title', 'id'))->required();
            })->when(3, function (Form $form)
            {
                $form->select('lesson_id', '課程名稱')->options(Lesson::where('course_id', 3)->get()->pluck('title', 'id'))->required();
            })->when(4, function (Form $form)
            {
                $form->select('lesson_id', '課程名稱')->options(Lesson::where('course_id', 4)->get()->pluck('title', 'id'))->required();
            })->when(5, function (Form $form)
            {
                $form->select('lesson_id', '課程名稱')->options(Lesson::where('course_id', 5)->get()->pluck('title', 'id'))->required();
            })->when(6, function (Form $form)
            {
                $form->select('lesson_id', '課程名稱')->options(Lesson::where('course_id', 6)->get()->pluck('title', 'id'))->required();
            });
        }

        $form->text('title', __('班級名稱'))->required();
        $form->text('description', __('說明'))->required();
        $form->datetime('start', __('簽到開始時間'))->default(date('Y-m-d 00:00:00'))->required();
        $form->datetime('end', __('簽到結束時間'))->default(date('Y-m-d 23:59:59'))->required();

        $form->tools(function (Form\Tools $tools) {
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

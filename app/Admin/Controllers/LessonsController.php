<?php

namespace App\Admin\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;


class LessonsController extends AdminController
{
    protected $title = '開課課程';

    public function index(Content $content)
    {
        $content->title('開課課程');
        $content->description('課程清單');

        $content->breadcrumb(
            ['text' => '開課課程', 'url' => '/lessons'],
        );
        $content->body($this->grid());
        return $content;
    }

    public function create(Content $content)
    {
        return $content
            ->header('開課課程')
            ->description('新增課程')
            ->breadcrumb(
                ['text' => '開課課程', 'url' => '/lessons'],
                ['text' => '新增', 'url' => '/lessons/create']
            )->body($this->form());
    }

    public function edit($id, Content $content)
    {
        return $content
            ->header('開課課程')
            ->description('編輯課程資訊')
            ->breadcrumb(
                ['text' => '開課課程', 'url' => '/lessons'],
                ['text' => '編輯', 'url' => '/lessons/' . $id . '/edit']
            )->body($this->form()->edit($id));
    }

    protected function grid()
    {
        $grid = new Grid(new Lesson());

        $grid->column('id', __('編號'));
        $grid->column('course.name', __('期別'));
        $grid->column('lesson_num', __('堂數'));
        $grid->column('title', __('名稱'));
//        $grid->column('subtitle', __('子名稱'));
        $grid->column('content', __('內容'));
        $grid->column('created_at', __('建立時間'));

        $grid->disableExport();
        $grid->disableColumnSelector();
        $grid->disableRowSelector();
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableDelete();
            $actions->disableView();
        });

        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->expand();
            $filter->like('course_id', '期別');
        });

        return $grid;
    }

    protected function form()
    {
        $form = new Form(new Lesson());

        $form->select('course_id', __('期別'))->options(Course::all()->pluck('name', 'id'))->required();
        $form->number('lesson_num', __('堂數'))->min(1)->required();
        $form->text('title', __('名稱'))->required();
        $form->text('subtitle', __('子名稱'))->required();
        $form->textarea('content', __('內容'))->required();

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

    public function apiIndex(Request $request)
    {
        // 用户输入的值通过 q 参数获取
        $search = $request->input('q');
        return Lesson::where('course_id', $search)->get()->pluck('title', 'id');
    }
}

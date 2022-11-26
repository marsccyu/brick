<?php

namespace App\Admin\Controllers;

use App\Models\Point_history;
use App\Models\Point_task;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Content;

class PointHistoriesController extends AdminController
{
    protected $title = '會員積分管理';
    protected $table = "point_histories";

    public function index(Content $content)
    {
        $content->title('會員積分管理');
        $content->description('會員積分異動清單');

        $content->breadcrumb(
            ['text' => '會員積分管理', 'url' => '/point_history'],
        );
        $content->body($this->grid());
        return $content;
    }

    public function create(Content $content)
    {
        return $content
            ->header('會員積分管理')
            ->description('新增會員積分紀錄')
            ->breadcrumb(
                ['text' => '會員積分管理', 'url' => '/point_history'],
                ['text' => '新增', 'url' => '/point_history/create']
            )->body($this->form());
    }

    protected function grid()
    {
        $grid = new Grid(new Point_history());

        $grid->column('id', __('編號'));
        $grid->column('point_task_id', __('積分任務編號'));
        $grid->column('user_id', __('會員編號'));
        $grid->column('user.name', __('會員名稱'));
        $grid->column('change', __('異動'));
        $grid->column('after', __('異動後積分'));
        $grid->column('comment', __('描述'));
        $grid->column('created_at', __('建立時間'));

        $grid->disableColumnSelector();
        $grid->disableRowSelector();
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableEdit();
//            $actions->disableDelete();
            $actions->disableView();
        });
        $grid->filter(function ($filter) {
            $filter->like('user_id', '會員編號');
        });
        return $grid;
    }

    protected function form()
    {
        $form = new Form(new Point_history());

        if ($uid = request()->route()->parameters('id'))
        {
            $form->text('point_task_id', __('積分任務編號'))->readonly();
            $form->text('user_id', __('會員編號'))->readonly();
            $form->decimal('before', __('異動前積分'))->readonly();
            $form->decimal('change', __('異動積分'))->readonly();
            $form->decimal('after', __('異動後積分'))->readonly();
            $form->text('description', __('描述'))->readonly();
            $form->text('comment', __('備註'));
        }
        else
        {
            $tasks = Point_task::all()->toArray();
            $options = [];
            foreach ($tasks as $task)
            {
                $point = (str_contains($task['point'], '-')) ? $task['point'] : "+".$task['point'];
                $options[$task['id']] = sprintf("%s (%s 分)", $task['description'], $point);
            }
            $form->select('point_task_id', __('對應積分項目'))->options($options)->required();

            $form->select('user_id', __('會員名稱'))->options(User::all()->pluck('name', 'id'))->required();
            $form->text('comment', __('備註'))->required();
            //保存前回调
            $form->saving(function (Form $form) {
                $all = request()->all();
                $userId = User::find($all['user_id'])->userId;
                $task_name = Point_task::find($all['point_task_id'])->name;

                $task = new Point_task();
                $doTask = $task->makeTask($task_name, $userId, $all['comment']);

                return redirect('/admin/point_history');
            });
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

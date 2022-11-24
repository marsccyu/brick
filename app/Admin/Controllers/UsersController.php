<?php

namespace App\Admin\Controllers;

use App\Models\Point_task;
use App\Models\SignIn;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;
use http\Client\Request;
use Encore\Admin\Layout\Content;

class UsersController extends AdminController
{
    protected $title = '會員清單';

    public function index(Content $content)
    {
        return $content
            ->header('會員清單')
            ->description('已完成綁定 Line 帳號會員清單')
            ->breadcrumb(['text' => '會員清單 - 管理', 'url' => '/users'],)
            ->body($this->grid());
    }

    public function edit($id, Content $content)
    {
        return $content
            ->header('會員清單')
            ->description('編輯會員資料 / 查看簽到及積分紀錄')
            ->breadcrumb(
                ['text' => '會員清單', 'url' => '/users'],
                ['text' => '編輯', 'url' => '/users/' . $id . '/edit']
            )->body($this->form()->edit($id));
    }

    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('Id'));
        $grid->column('type', '類型')->display(function ($value) {
            switch ($value)
            {
                case "parents" :
                    $value = "家長";
                    $color = "red";
                    break;

                case "student":
                    $value = "學生";
                    $color = "blue";
                    break;
            }
            return "<span style='color:".$color."'>$value</span>";
        });
        $grid->column('name', __('姓名'));
        $grid->column('userId', __('User id'));
        $grid->column('email', __('Email'));
        $grid->column('telephone', __('電話'));
        $grid->column('created_at', __('加入時間'));
        $grid->disableCreateButton();
        $grid->disableExport();
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
        $form = new Form(new User());

        $form->tab('會員資料', function ($form) {
            $form->text('userId', __('Line Uid'))->readonly();
            $form->radio('type', '類型')->options(['parents' => '家長', 'student' => '學生'])->default('student');
            $form->text('name', __('姓名'))->required();
            $form->email('email', __('Email'))->required();
            $form->text('telephone', __('電話'))->required();
            $form->text('age', __('年齡'))->readonly();
            $form->text('created_at', __('加入時間'))->readonly();
        })->tab('簽到紀錄', function ($form) {
		    $uid = request()->route()->parameters()['id'];

		    $rows = [];
            if ($signIns = SignIn::where('user_id', $uid)->paginate(50))
            {
                foreach ($signIns as $signIn)
                {
                    $rows[] = [
                        'id' => $signIn->id,
                        'lesson_title' => ($signIn->lesson['title']) ?? "",
                        'classes_title' => ($signIn->classes['title']) ?? "",
                        'created_at' => $signIn->created_at,
                    ];
                }
                $headers = ['編號', '課程名稱', '班級名稱', '時間'];
                $table = new Table($headers, $rows);
                $form->html($table, __(''))->readonly();
                $form->html($signIns->fragment('tab-form-2')->links(), __(''));
            }
        })->tab('積分紀錄', function ($form) {
		
	        $uid = request()->route()->parameters()['id'];

            $rows = [];
            if ($users = User::find($uid)->Point_history()->paginate(50))
            {
                $point_task = Point_task::get()->toArray();

                foreach ($point_task as $task)
                {
                    $task_info[$task['id']] = $task;
                }

                foreach ($users as $user)
                {
                    $rows[] = [
                        $user->id,
                        $user->change,
                        $user->after,
                        $task_info[$user['point_task_id']]['description'],
                        ($user->comment) ?? '',
                        $user->created_at,
                    ];
                }
            }

            $headers = ['編號', '積分異動', '結算積分', '說明', '備註', '時間'];

            $table = new Table($headers, $rows);
            $form->html($table, __(''))->readonly();

            $form->html($users->fragment('tab-form-3')->links(), __(''));

            $point = User::find($uid)->point->point;
            $form->html(sprintf("累積積分 : %s 分", $point), __(''));
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

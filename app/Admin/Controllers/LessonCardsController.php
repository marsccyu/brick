<?php

namespace App\Admin\Controllers;

use App\Models\LessonCard;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Content;

class LessonCardsController extends AdminController
{
    protected $title = '課程介紹管理';

    public function index(Content $content)
    {
        return $content
            ->header('課程介紹管理')
            ->description('"課程介紹"聊天室視窗回覆訊息')
                ->breadcrumb(['text' => '課程介紹管理 - 管理', 'url' => '/lesson_cards'],)
            ->body($this->grid());
    }

    public function edit($id, Content $content)
    {
        return $content
            ->header('編輯課程介紹')
            ->description('編輯"課程介紹"聊天室視窗回覆訊息')
            ->breadcrumb(
                    ['text' => '課程介紹管理', 'url' => '/lesson_cards'],
                    ['text' => '編輯', 'url' => '/lesson_cards/' . $id . '/edit']
            )->body($this->form()->edit($id));
    }

    protected function grid()
    {
        $grid = new Grid(new LessonCard());

        $grid->column('id', __('Id'));
        $grid->column('title', __('標題'));
        $grid->column('subtitle', __('子標題'));
        $grid->column('display', '是否顯示於"課程介紹"回覆訊息')->display(function ($value) {

            switch ($value)
            {
                case 0:
                    $txt = "否";
                    $color = "red";
                    break;

                case 1:
                    $txt = "是";
                    $color = "green";
                    break;

                default:
                    $txt = "無";
                    $color = "blue";
                    break;
            }

            return sprintf("<span style='color:%s'>%s</span>", $color, $txt) ;
        });
//        $grid->column('content', __('內容'));

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
        $form = new Form(new LessonCard());

        $form->tools(function (Form\Tools $tools) {
            // 去掉`删除`按钮
            $tools->disableDelete();
            // 去掉`查看`按钮
            $tools->disableView();
        });

        $form->text('title', __('標題'))->required();;
        $form->text('subtitle', __('子標題'))->required();

//        $form->image('image', __('Image'));

        $form->switch('display', __('是否顯示於聊天視窗內'));
        $form->textarea('content', __('內容'))->required();;

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

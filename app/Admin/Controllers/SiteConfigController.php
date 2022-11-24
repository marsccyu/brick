<?php

namespace App\Admin\Controllers;

use App\Models\Site_config;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Content;

class SiteConfigController extends AdminController
{
    protected $title = '參數設定';

    public function index(Content $content)
    {
        $content->title('參數設定');
        $content->description('管理全站參數設定內容');

        $content->breadcrumb(
            ['text' => '參數設定', 'url' => '/site_config'],
        );
        $content->body($this->grid());
        return $content;
    }

    public function edit($id, Content $content)
    {
        return $content
            ->header('參數設定')
            ->description('編輯管理全站參數設定內容')
            ->breadcrumb(
                ['text' => '參數設定', 'url' => '/site_config'],
                ['text' => '編輯', 'url' => '/site_config/' . $id . '/edit']
            )->body($this->form()->edit($id));
    }

    protected function grid()
    {
        $grid = new Grid(new Site_config());

        $grid->column('id', __('Id'));
//        $grid->column('key', __('參數名稱'));
        $grid->column('description', __('說明'));
        $grid->column('value', '內容')->display(function ($value) {
            switch ($value) {
                case '1':
                    $text = '開啟';
                    $color = 'green';
                    break;
                case '0':
                    $text = '關閉';
                    $color = 'red';
                    break;
                default:
                    $text = $value;
                    $color = 'black';
                    break;
            }
            return "<span style='color:".$color."'>$text</span>";
        });

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
        $form = new Form(new Site_config());

        $id = request()->route()->parameters()['id'];
//        $form->text('key', __('參數名稱'))->readonly();
        $form->text('description', __('說明'))->readonly();
        if (in_array($id, [4, 5]))
        {
            $form->switch('value', __('狀態'));
        }
        else {
            $form->textarea('value', __('內容'));
        }

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

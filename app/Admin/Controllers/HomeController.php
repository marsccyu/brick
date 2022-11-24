<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->title('管理後台首頁')
            ->description(' ')
            ->row('')
            ->row(function (Row $row) {

//                $row->column(4, function (Column $column) {
//                    $column->append(Dashboard::environment());
//                });
//
//                $row->column(4, function (Column $column) {
//                    $column->append(Dashboard::extensions());
//                });
//
//                $row->column(4, function (Column $column) {
//                    $column->append(Dashboard::dependencies());
//                });
            });
    }

    public function sma()
    {
        return;
        $grid = new Grid(new CouponCode);

        $grid->model()->orderBy('created_at', 'desc');
        $grid->id('ID')->sortable();

        $form->display('subtitle', __('子標題'))->with(function ($value) {
            return $value . '123';
        });
    }
}

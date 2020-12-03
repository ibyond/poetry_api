<?php

namespace App\Admin\Controllers;

use App\Models\HostSearch;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class HostSearchController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'HostSearch';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new HostSearch());

        $grid->model()->orderBy('num');

        $grid->column('id', __('ID'));
        $grid->column('content', __('搜索词'));
        $grid->column('num', __('热度'));
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('更新时间'));

        $grid->paginate(16);
        $grid->disableExport();
        $grid->filter(function ($filter) {
            $filter->like('content', '搜索词');
        });
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(HostSearch::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('content', __('搜索词'));
        $show->field('num', __('热度'));
        $show->field('created_at', __('创建时间'));
        $show->field('updated_at', __('更新时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new HostSearch());

        $form->display('id', 'ID');
        $form->text('content', __('搜索词'));
        $form->number('num', __('热度'));

        return $form;
    }
}

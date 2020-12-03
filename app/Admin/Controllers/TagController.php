<?php

namespace App\Admin\Controllers;

use App\Models\Tag;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TagController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '标签';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Tag());

        $grid->model()->select([
            'id', 'name', 'desc', 'status', 'sort'
        ])->orderBy('sort');

        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('标签名'))->filter();
        $grid->column('desc', __('描述'));

        $states = [
            'on' => ['value' => Tag::STATUS_NORMAL, 'text' => '正常', 'color' => 'success'],
            'off'  => ['value' => Tag::STATUS_HIDEN, 'text' => '隐藏', 'color' => 'danger'],
        ];
        $grid->column('status', __('状态'))->switch($states);

        $grid->column('sort', __('排序'))->help('越小权重越靠前')->editable()->sortable();

        $grid->paginate(16);
        $grid->disableExport();
        $grid->filter(function ($filter) {
            $filter->like('name', '标签名');
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
        $show = new Show(Tag::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('name', __('标签名'));
        $show->field('desc', __('描述'));
        $show->field('status', __('状态'))->using(['0' => '隐藏', '1' => '正常'])->label();
        $show->field('sort', __('排序'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Tag());

        $form->display('id', 'ID');
        $form->text('name', __('标签名'));
        $form->textarea('desc', __('描述'));
        $states = [
            'on'  => ['value' => Tag::STATUS_NORMAL, 'text' => '正常', 'color' => 'success'],
            'off' => ['value' => Tag::STATUS_HIDEN, 'text' => '隐藏', 'color' => 'danger'],
        ];

        $form->switch('status', __('状态'))->states($states);
        $form->number('sort', __('排序'))->default(100);
        return $form;
    }
}

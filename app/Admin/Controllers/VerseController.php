<?php

namespace App\Admin\Controllers;

use App\Models\Poet;
use App\Models\Poetry;
use App\Models\Verse;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class VerseController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '名句';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Verse());

        $grid->model()->select([
            'id',
            'content',
            'poet_name',
            'poetry_name',
            'star',
            'status',
            'updated_at'
        ])->orderBy('star', 'desc');
        $grid->column('id', __('ID'));
        $grid->column('content', __('名句'));
        $grid->column('poet_name', __('作者'));
        $grid->column('poetry_name', __('诗词名'));
        $grid->column('star', __('点赞数'));
        $states = [
            'on' => ['value' => Verse::STATUS_NORMAL, 'text' => '正常', 'color' => 'success'],
            'off'  => ['value' => Verse::STATUS_HIDEN, 'text' => '隐藏', 'color' => 'warning'],
        ];
        $grid->column('status', __('状态'))->switch($states);
        $grid->column('updated_at', __('更新时间'));

        $grid->paginate(16);
        $grid->disableExport();
        $grid->filter(function ($filter) {
            $filter->like('poet_name', '作者');
            $filter->like('content', '名句');
            $filter->like('poetry_name', '诗词名');
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
        $show = new Show(Verse::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('content', __('名句'));
        $show->field('poet_name', __('作者'));
        $show->field('poetry_name', __('诗词名'));
        $show->field('star', __('点赞数'));
        $show->field('status', __('状态'))->using(['0' => '隐藏', '1' => '正常'])->label();
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Verse());
        $form->display('id', 'ID');

        $form->textarea('content', __('名句'));
        $form->hidden('poet_id');
        $form->text('poet_name', __('作者'));
        $form->hidden('poetry_id');
        $form->text('poetry_name', __('诗词名'));
        $form->number('star', __('点赞数'));
        $states = [
            'on'  => ['value' => Verse::STATUS_NORMAL, 'text' => '正常', 'color' => 'success'],
            'off' => ['value' => Verse::STATUS_HIDEN, 'text' => '隐藏', 'color' => 'danger'],
        ];

        $form->switch('status', __('状态'))->states($states);

        $form->saving(function (Form $form) {

            $poet = Poet::query()->select('id')->where('name', $form->poet_name)->first();
            if (!$poet) {
                abort(404, '未找到诗人：' . $form->poet_name);
            }

            $poetry = Poetry::query()->select('id')->where('name', $form->poetry_name)->first();
            if (!$poetry) {
                abort(404, '未找到诗词：' . $form->poetry_name);
            }
            $form->poet_id = $poet->id;
            $form->poetry_id = $poetry->id;

        });

        return $form;
    }
}

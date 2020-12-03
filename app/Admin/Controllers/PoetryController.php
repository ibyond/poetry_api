<?php

namespace App\Admin\Controllers;

use App\Models\Dynasty;
use App\Models\Poet;
use App\Models\Poetry;
use App\Models\Tag;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Str;

class PoetryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '诗词';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Poetry());

        $grid->model()
            ->select([
                'id',
                'name',
                'dynasty_name',
                'content',
                'status',
                'star',
            ])->orderBy('star', 'desc');

        $grid->column('id', __('ID'));
        $grid->column('name', __('诗词名'))->filter();
        $grid->column('dynasty_name', __('朝代'));
//        $grid->column('poet.name', __('作者'));
        $grid->column('content', __('内容片段'))->display(function ($conent) {
            return trim(Str::limit($conent, 40));
        });

        $states = [
            'on' => ['value' => Poetry::STATUS_NORMAL, 'text' => '正常', 'color' => 'success'],
            'off'  => ['value' => Poetry::STATUS_HIDEN, 'text' => '隐藏', 'color' => 'warning'],
        ];
        $grid->column('status', __('状态'))->switch($states);
        $grid->column('star', __('点赞数'))->sortable();

        $grid->paginate(16);
        $grid->disableExport();
        $grid->filter(function ($filter) {
            $filter->like('poet.name', '作者');
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
        $show = new Show(Poetry::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('name', __('诗词名'));
        $show->field('dynasty_name', __('朝代'));
        $show->field('content', __('内容'));
        $show->field('author', __('作者简介'));
        $show->field('fanyi', __('翻译'));
        $show->field('shangxi', __('赏析'));
        $show->field('about', __('关于'));
        $show->field('status', __('状态'))->using(['0' => '隐藏', '1' => '正常'])->label();
        $show->field('star', __('点赞数'));
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
        $form = new Form(new Poetry());

        $form->display('id', 'ID');
        $form->text('name', __('诗词名'));
        $form->hidden('dynasty_name');
        $form->select('dynasty_id', '朝代')->options('/admin/dynasties/list');
        $form->textarea('content', __('内容'));
        $form->textarea('author', __('作者简介'))->rows(10);
        $form->hidden('poet_name');
        $form->select('poet_id', '作者')->options(function ($id) {
            $poet = Poet::find($id);

            if ($poet) {
                return [$poet->id => $poet->name];
            }
        })->ajax('/admin/poets/list');
        $form->textarea('fanyi', __('翻译'))->rows(15);
        $form->textarea('shangxi', __('赏析'))->rows(20);
        $form->textarea('about', __('关于'))->rows(10);
        $states = [
            'on'  => ['value' => Poetry::STATUS_NORMAL, 'text' => '正常', 'color' => 'success'],
            'off' => ['value' => Poetry::STATUS_HIDEN, 'text' => '隐藏', 'color' => 'danger'],
        ];

        $form->multipleSelect('tags', '标签')->options(Tag::all()->pluck('name', 'id'));

        $form->switch('status', __('状态'))->states($states);
        $form->number('star', __('点赞数'));

        $form->saving(function (Form $form) {

            $dynasty_name = Dynasty::query()->select('name')->where('id', $form->dynasty_id)->firstOrFail();
            $form->dynasty_name = $dynasty_name->name;
            $poet_name = Poet::query()->select('name')->where('id', $form->poet_id)->firstOrFail();
            $form->poet_name = $poet_name->name;
        });
        return $form;
    }
}

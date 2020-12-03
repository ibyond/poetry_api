<?php

namespace App\Admin\Controllers;

use App\Models\Dynasty;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class DynastyController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '朝代';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Dynasty());

        $grid->model()->select([
            'id',
            'name',
            'desc',
            'created_at',
            'updated_at',
        ]);
        $grid->column('id', __('ID'));
        $grid->column('name', __('朝代'))->filter('like');
        $grid->column('desc', __('描述'))->limit(30)->width(400);
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('更新时间'));

        $grid->paginate(10);
        $grid->disableExport();
        $grid->filter(function ($filter) {
            $filter->like('name', '朝代');
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
        $show = new Show(Dynasty::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('name', __('朝代'));
        $show->field('desc', __('描述'));
        $show->field('created_at', __('创建时间'));
        $show->field('updated_at', __('更新时间'));

        $show->panel()
            ->tools(function ($tools) {
                $tools->disableDelete();
            });;
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Dynasty());

        $form->text('name', __('朝代'));
        $form->textarea('desc', __('描述'));

        return $form;
    }

    public function list()
    {
        return Dynasty::query()->selectRaw('id, name as text')->get();
    }
}

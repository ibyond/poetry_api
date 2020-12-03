<?php

namespace App\Admin\Controllers;

use App\Models\Dynasty;
use App\Models\Poet;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Http\Request;

class PoetController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '诗人';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Poet());

        $grid->model()->select([
            'id', 'name', 'image', 'star', 'created_at', 'updated_at', 'dynasty_name'
        ])->orderBy('star', 'desc');

        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('诗人'));
        $grid->column('image', __('头像'))->image('', 50, 50);
        $grid->column('dynasty_name', __('朝代'));
        $grid->column('star', __('点赞数'))->sortable();
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('更新时间'));

        $grid->paginate(10);
        $grid->disableExport();

        $grid->filter(function ($filter) {
            $filter->like('name', '诗人');
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
        $show = new Show(Poet::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('name', __('诗人'));
        $show->field('image', __('头像'))->image();
        $show->field('dynasty_name', __('朝代'));
        $show->field('desc', __('简介'));
        $show->field('content', __('内容'));
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
        $form = new Form(new Poet());
        $form->display('id', 'ID');
        $form->text('name', __('诗人'));
        $form->image('image', __('头像'));
        $form->hidden('dynasty_name');
        $form->select('dynasty_id', '朝代')->options('/admin/dynasties/list');
        $form->textarea('desc', __('简介'));
        $form->textarea('content', __('内容'));
        $form->number('star', __('点赞数'));

        $form->saving(function (Form $form) {

            $dynasty_name = Dynasty::query()->select('name')->where('id', $form->dynasty_id)->firstOrFail();
            $form->dynasty_name = $dynasty_name->name;

        });
        return $form;
    }

    public function list(Request $request)
    {
        $q = $request->get('q');

        return Poet::where('name', 'like', "$q%")->paginate(null, ['id', 'name as text']);
    }
}

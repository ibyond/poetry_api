<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('Id'));
        $grid->column('username', __('Username'));
        $grid->column('name', __('Name'));
        $grid->column('real_name', __('Real name'));
        $grid->column('avatar', __('Avatar'));
        $grid->column('email', __('Email'));
        $grid->column('gender', __('Gender'));
        $grid->column('phone', __('Phone'));
        $grid->column('birthday', __('Birthday'));
        $grid->column('password', __('Password'));
        $grid->column('api_token', __('Api token'));
        $grid->column('status', __('Status'));
        $grid->column('frozen_at', __('Frozen at'));
        $grid->column('status_remark', __('Status remark'));
        $grid->column('email_verified_at', __('Email verified at'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('remember_token', __('Remember token'));
        $grid->column('deleted_at', __('Deleted at'));

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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('username', __('Username'));
        $show->field('name', __('Name'));
        $show->field('real_name', __('Real name'));
        $show->field('avatar', __('Avatar'));
        $show->field('email', __('Email'));
        $show->field('gender', __('Gender'));
        $show->field('phone', __('Phone'));
        $show->field('birthday', __('Birthday'));
        $show->field('password', __('Password'));
        $show->field('api_token', __('Api token'));
        $show->field('status', __('Status'));
        $show->field('frozen_at', __('Frozen at'));
        $show->field('status_remark', __('Status remark'));
        $show->field('email_verified_at', __('Email verified at'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('remember_token', __('Remember token'));
        $show->field('deleted_at', __('Deleted at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->text('username', __('Username'));
        $form->text('name', __('Name'));
        $form->text('real_name', __('Real name'));
        $form->image('avatar', __('Avatar'));
        $form->email('email', __('Email'));
        $form->text('gender', __('Gender'))->default('none');
        $form->mobile('phone', __('Phone'));
        $form->date('birthday', __('Birthday'))->default(date('Y-m-d'));
        $form->password('password', __('Password'));
        $form->textarea('api_token', __('Api token'));
        $form->text('status', __('Status'))->default('inactivated');
        $form->datetime('frozen_at', __('Frozen at'))->default(date('Y-m-d H:i:s'));
        $form->datetime('status_remark', __('Status remark'))->default(date('Y-m-d H:i:s'));
        $form->datetime('email_verified_at', __('Email verified at'))->default(date('Y-m-d H:i:s'));
        $form->text('remember_token', __('Remember token'));

        return $form;
    }
}

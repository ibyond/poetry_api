<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\AdminRequest;
use App\Http\Requests\Api\UserRequest;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @param UserRequest $request
     *
     * @return mixed
     */
    public function store(UserRequest $request)
    {
        User::create($request->all());
        return $this->setStatusCode(201)->success('用户注册成功!');
    }

    /**
     * @param AdminRequest $request
     *
     * @return mixed
     */
    public function adminStore(AdminRequest $request)
    {
        Admin::create($request->all());
        return $this->setStatusCode(201)->success('后台用户注册成功!');
    }
}

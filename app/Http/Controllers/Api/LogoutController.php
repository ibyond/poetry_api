<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout()
    {
        Auth::logout();
        return $this->success('退出成功...');
    }
}

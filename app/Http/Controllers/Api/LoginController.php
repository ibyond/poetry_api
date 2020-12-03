<?php

namespace App\Http\Controllers\Api;

use App\Jobs\Api\SaveLastTokenJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class LoginController extends Controller
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

    public function login(Request $request)
    {
        //获取当前守护的名称
        $present_guard = Auth::getDefaultDriver();
        $token = Auth::claims(['guard' => $present_guard])->attempt(['username' => $request->username, 'password' => $request->password]);
        if ($token) {
            //如果登陆，先检查原先是有存token，有的话先失效，然后再存入最新的token否
            $user = Auth::user();
            if ($user->api_token) {
                try {
                    Auth::setToken($user->api_token)->invalidate();
                } catch (TokenExpiredException $e) {
                    //因为让一个过期的token再失效，会抛出异常，所以我们捕捉异常，不需要做任何处理
                }
            }
            SaveLastTokenJob::dispatch($user, $token);
            return $this->setStatusCode(201)->success($this->respondWithToken($token));
        }
        return $this->failed('账号或密码错误', 400);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return array
     */
    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ];
    }
}

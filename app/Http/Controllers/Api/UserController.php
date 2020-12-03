<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function info()
    {
        $user = Auth::user();
        return $this->success(new UserResource($user));
    }

    public function index()
    {
        $users = User::paginate(3);
        return UserResource::collection($users);
    }


    public function show(User $user)
    {
        return $this->success(new UserResource($user));
    }

}

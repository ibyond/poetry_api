<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VerseController;
use App\Http\Controllers\Api\DynastyController;
use App\Http\Controllers\Api\PoetController;
use App\Http\Controllers\Api\PoetryController;
use App\Http\Controllers\Api\HostSearchController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {

    //朝代列表
    Route::get('/dynasties', [DynastyController::class, 'index'])->name('dynasties.index');
    //名句列表
    Route::get('/verses', [VerseController::class, 'index'])->name('verses.index');
    //今日名句
    Route::get('/verses/today', [VerseController::class, 'today'])->name('verses.today');

    //诗词列表
    Route::get('/poetries', [PoetryController::class, 'index'])->name('poetries.index');
    //诗词详情
    Route::get('/poetries/{id}', [PoetryController::class, 'show'])->name('poetries.show');

    //诗人的诗
    Route::get('/poets/{id}/list', [PoetryController::class, 'list'])->name('poets.list');

    //诗人列表
    Route::get('/poets', [PoetController::class, 'index'])->name('poets.index');
    //诗人详情
    Route::get('/poets/{poet}', [PoetController::class, 'show'])->name('poets.show');

    //热门搜索
    Route::get('/host', [HostSearchController::class, 'index'])->name('host.index');

    Route::middleware('api.guard')->group(function () {
        //用户注册
        Route::post('/users', [RegisterController::class, 'store'])->name('users.store');
        //用户登录
        Route::post('/login', [LoginController::class, 'login'])->name('users.login');
        Route::middleware('token.refresh')->group(function () {
            //当前用户信息
            Route::get('/users/info', [UserController::class, 'info'])->name('users.info');
            //用户列表
            Route::get('/users', [UserController::class, 'index'])->name('users.index');
            //用户信息
            Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
            //用户退出
            Route::get('/logout', [LogoutController::class, 'logout'])->name('users.logout');
        });
    });


});



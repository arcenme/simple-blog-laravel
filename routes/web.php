<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\BlogController as DashboardBlogController;
use App\Http\Controllers\Dashboard\CommentController as DashboardCommentController;
use App\Http\Controllers\Dashboard\UserController as DashboardUserController;
use App\Http\Controllers\LandingPages\BlogController;
use App\Http\Controllers\LandingPages\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth::routes();

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'authenticated']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('', function () {
    return redirect()->route('blog');
})->name('index');

Route::group(['prefix' => 'blog'], function () {
    Route::get('', [BlogController::class, 'index'])->name('blog');
    Route::get('/{slug}', [BlogController::class, 'show'])->name('blog.detail');

    Route::group(['prefix' => 'comment'], function () {
        Route::get('comment/{slug}', [CommentController::class, 'index'])->name('blog.comment');
        Route::post('comment/{slug}', [CommentController::class, 'store']);
    });
});

Route::group(['middleware' => 'auth:admin,user', 'prefix' => 'dashboard'], function () {
    Route::group(['prefix' => 'blog'], function () {
        Route::get('', [DashboardBlogController::class, 'index'])->name('dashboard.blog');
        Route::get('post', [DashboardBlogController::class, 'show'])->name('dashboard.blog.post');
        Route::post('post', [DashboardBlogController::class, 'create']);
        Route::put('post', [DashboardBlogController::class, 'update']);
        Route::delete('post', [DashboardBlogController::class, 'destroy'])->middleware('auth:admin');
    });

    Route::group(['prefix' => 'profile'], function () {
        Route::get('', [DashboardUserController::class, 'index'])->name('dashboard.profile');
        Route::put('', [DashboardUserController::class, 'updateProfile']);
        Route::put('password', [DashboardUserController::class, 'updatePassword'])->name('dashboard.profile.password');
    });

    Route::group(['prefix' => 'comment'], function () {
        Route::get('', [DashboardCommentController::class, 'index'])->name('dashboard.comment');
        Route::delete('', [DashboardCommentController::class, 'destroy']);
    });
});

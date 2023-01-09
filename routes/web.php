<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LandingPages\BlogController;
use App\Http\Controllers\LandingPages\CommentController;
use App\Http\Controllers\PostController;
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
    Route::get('', [BlogController::class, 'blog'])->name('blog');
    Route::get('/{slug}', [BlogController::class, 'blogDetail'])->name('blog.detail');

    Route::group(['prefix' => 'comment'], function () {
        Route::get('comment/{slug}', [CommentController::class, 'index'])->name('blog.comment');
        Route::post('comment/{slug}', [CommentController::class, 'store']);
    });
});

Route::group(['middleware' => 'auth:admin,user', 'prefix' => 'dashboard'], function () {
    Route::group(['prefix' => 'blog'], function () {
        Route::get('', [BlogController::class, 'blogList'])->name('dashboard.blog');
        Route::get('post', [BlogController::class, 'blogPost'])->name('dashboard.blog.post');
        Route::post('post', [BlogController::class, 'blogPost']);
    });
});

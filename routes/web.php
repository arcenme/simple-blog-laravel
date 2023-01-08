<?php

use App\Http\Controllers\LandingPages\BlogController;
use App\Http\Controllers\LandingPages\CommentController;
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

Route::get('', function () {
    return redirect()->route('blog');
})->name('index');

Route::group(['prefix' => 'blog'], function () {
    Route::get('', [BlogController::class, 'index'])->name('blog');
    Route::get('/{slug}', [BlogController::class, 'show'])->name('blog.detail');

    Route::group(['prefix' => 'comment'], function () {
        Route::get('comment/{slug}', [CommentController::class, 'index'])->name('blog.comment');
    });
});

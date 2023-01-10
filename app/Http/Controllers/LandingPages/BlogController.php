<?php

namespace App\Http\Controllers\LandingPages;

use App\Http\Controllers\Controller;
use App\Services\BlogDetailService;
use App\Services\BlogService;
use App\Services\CommentService;
use App\Services\ErrorService;
use Illuminate\Validation\Rule;
use Stevebauman\Purify\Facades\Purify;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = BlogService::get();

        return view('pages.landing_pages.blog.index', compact('blogs'));
    }

    public function show($slug)
    {
        $blog = BlogDetailService::show($slug);

        return view('pages.landing_pages.blog.detail', compact('blog'));
    }
}

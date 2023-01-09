<?php

namespace App\Http\Controllers\LandingPages;

use App\Http\Controllers\Controller;
use App\Services\BlogDetailService;
use App\Services\BlogService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function blog()
    {
        $blogs = BlogService::get();

        return view('pages.landing_pages.blog.index', compact('blogs'));
    }

    public function blogDetail($slug)
    {
        $blog = BlogDetailService::show($slug);

        return view('pages.landing_pages.blog.detail', compact('blog'));
    }

    public function blogList()
    {
        if (request()->ajax()) {
            return BlogService::getTable();
        }

        return view('pages.dashboard.post.index');
    }

    public function blogPost()
    {
        $blog = collect([]);

        // action = edit
        if (request()->has('slug'))
            $blog = BlogDetailService::show(request('slug'));

        return view('pages.dashboard.post.post', compact('blog'));
    }
}

<?php

namespace App\Http\Controllers\LandingPages;

use App\Http\Controllers\Controller;
use App\Services\BlogDetailService;
use App\Services\BlogService;
use App\Services\CommentService;
use App\Services\ErrorService;
use Stevebauman\Purify\Facades\Purify;

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
        $blog = [];

        // action = edit
        if (request()->has('slug'))
            $blog = BlogDetailService::show(request('slug'))->toArray();

        return view('pages.dashboard.post.post', compact('blog'));
    }

    public function createBlog()
    {
        request()->validate([
            'slug' => 'bail|nullable|exists:blogs,slug',
            'title' => 'bail|required|max:200',
            'thumbnail' => 'bail|required_without:slug|image|max:1024',
            'title_slug' => 'bail|required|max:255',
            'content' => 'bail|required|max:65535'
        ], ['content.max' => 'The content field is to long.']);

        // create or update data
        $payload = collect([
            'slug' =>  request('slug'),
            'title' =>  request('title'),
            'title_slug' =>  request('title_slug'),
            'content' =>  Purify::clean(request('content')),
        ]);

        // save file
        if (request()->file('thumbnail')) {
            $fileName = request()->file('thumbnail')->store('blog/' . auth()->id());
            $payload['thumbnail'] = $fileName;
        }

        BlogService::create($payload);

        // return
        return redirect()->route('dashboard.blog')->with('success', 'Data saved successfully');
    }

    public function deleteBlog()
    {
        request()->validate(['slug' => 'bail|required']);

        // get blog data
        $blog = BlogDetailService::getBySlug(request('slug'));
        if (!$blog)
            return ErrorService::returnJson(404, 'Data not found.');

        // delete comments
        CommentService::deleteByBlog($blog->id);

        // delete thumbnail
        BlogDetailService::deleteThumbnail($blog->thumbnail);

        // delete data
        $blog->delete();

        // return
        return response()->json([
            'status' => true,
            'message' => 'Data deleted successfully'
        ]);
    }
}

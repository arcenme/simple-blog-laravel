<?php

namespace App\Services;

use App\Models\Blog;

class BlogService
{
    public static function get()
    {
        $data = Blog::select('title', 'slug', 'thumbnail')
            ->selectRaw('substring(content,1,125) as preview')
            ->selectRaw('(select count(*) from comments as c where blogs.id = c.blog_id) as comment')
            ->latest()
            ->paginate(12);

        return $data;
    }

    public static function getTable()
    {
        $data = Blog::latest()
            ->select('title', 'slug', 'created_at as publish_date');

        // fetch only blog if user is creator or admin filter is "mine"
        if ((auth()->guard('admin')->check() && request()->has('filter') && request('filter') === 'mine')   || (auth()->guard('user')->check()))
            $data->where('created_by', auth()->id());

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public static function create($payload): void
    {
        // craete data
        Blog::create($payload);
    }

    public static function update($payload): void
    {
        // data to be inserted
        $data = [
            'title' =>  $payload['title'],
            'slug' =>  $payload['title_slug'],
            'content' =>  $payload['content'],
        ];

        // add thumbnail
        if ($payload->has('thumbnail'))
            $data['thumbnail'] =  $payload['thumbnail'];

        // update data
        Blog::where('slug', $payload['slug'])
            ->update($data);
    }
}

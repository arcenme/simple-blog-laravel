<?php

namespace App\Services;

use App\Models\Blog;

class BlogService
{
    public static function get()
    {
        $data = Blog::select('title', 'slug')
            ->selectRaw('substring(content,1,125) as preview')
            ->selectRaw('(select count(*) from comments as c where blogs.id = c.blog_id) as comment')
            ->latest()
            ->paginate(12);

        return $data;
    }

    public static function getTable()
    {
        $data = Blog::select('title', 'slug', 'created_at as publish_date');

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->make(true);
    }
}

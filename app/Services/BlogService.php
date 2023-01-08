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
}

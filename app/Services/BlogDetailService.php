<?php

namespace App\Services;

use App\Models\Blog;

class BlogDetailService
{
    public static function show($slug)
    {
        $data = Blog::with(['author' => function ($query) {
            return $query->select('id', 'name');
        }])
            ->select('title', 'slug', 'content', 'created_by', 'updated_at')
            ->where('slug', $slug)
            ->firstOrFail();

        return $data;
    }
}

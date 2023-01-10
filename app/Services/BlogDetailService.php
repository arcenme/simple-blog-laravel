<?php

namespace App\Services;

use App\Models\Blog;
use Illuminate\Support\Facades\Storage;

class BlogDetailService
{
    public static function show($slug)
    {
        $data = Blog::with(['author' => function ($query) {
            return $query->select('id', 'name');
        }])
            ->select('title', 'slug', 'content', 'thumbnail', 'created_by', 'updated_at')
            ->where('slug', $slug)
            ->firstOrFail();

        return $data;
    }

    public static function getBySlug($slug)
    {
        $data = Blog::where('slug', $slug)->first();

        return $data;
    }

    public static function deleteThumbnail($path): void
    {
        if (Storage::exists($path))
            Storage::delete($path);
    }

    public static function deleteBlog(int $id): void
    {
        Blog::where('id', $id)->delete();
    }
}

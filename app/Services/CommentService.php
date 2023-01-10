<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\Comment;

class CommentService
{
    public static function getOffset(int $offset, $slug)
    {
        $data = Comment::join('blogs as b', 'comments.blog_id', 'b.id')
            ->select('name', 'comments.content', 'comments.created_at')
            ->where('slug', $slug)
            ->offset($offset)
            ->limit(5)
            ->latest()
            ->get();

        return $data;
    }

    public static function create(array $payload)
    {
        $blog = Blog::where('slug', $payload['slug'])
            ->select('id')
            ->first();

        $comment = Comment::create([
            'name' => $payload['fullname'],
            'email' => $payload['email'],
            'content' => $payload['comment'],
            'blog_id' => $blog['id'],
        ]);

        return $comment;
    }

    public static function deleteByBlog($blogId): void
    {
        Comment::where('blog_id', $blogId)->delete();
    }
}

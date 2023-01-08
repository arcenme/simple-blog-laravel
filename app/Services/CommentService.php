<?php

namespace App\Services;

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
}

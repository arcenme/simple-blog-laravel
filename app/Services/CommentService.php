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

    public static function getTable()
    {
        $data = Comment::join('blogs', 'comments.blog_id', 'blogs.id')
            ->select('comments.id', 'comments.name', 'comments.email', 'comments.content', 'comments.created_at')
            ->latest();

        // fetch only blog if user is creator or admin filter is "mine"
        if ((auth()->guard('admin')->check() && request()->has('filter') && request('filter') === 'mine')   || (auth()->guard('user')->check()))
            $data->where('created_by', auth()->id());

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->make(true);
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

    public static function getOneWithBlog(int $id)
    {
        return Comment::with('blog')
            ->where('id', $id)
            ->first();
    }
}

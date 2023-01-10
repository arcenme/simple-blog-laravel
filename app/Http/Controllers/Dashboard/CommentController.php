<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return CommentService::getTable();
        }

        return view('pages.dashboard.comment.index');
    }

    public function destroy()
    {
        request()->validate(['id' => 'bail|required|integer']);

        $comment =  CommentService::getOneWithBlog(request('id'));

        // validate author
        $this->authorize('delete', $comment);

        // delete data
        $comment->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data successfully deleted.'
        ]);
    }
}

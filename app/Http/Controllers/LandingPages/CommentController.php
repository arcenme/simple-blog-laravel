<?php

namespace App\Http\Controllers\LandingPages;

use App\Http\Controllers\Controller;
use App\Services\CommentService;
use App\Services\ErrorService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        if (request()->ajax()) {
            if (!request()->has('offset'))
                return ErrorService::returnJson(400, 'Bad request');

            $data = CommentService::getOffset(request('offset'), $slug);

            return response()->json([
                'staus' => true,
                'data' => $data
            ]);
        }

        return abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $slug)
    {
        $request->merge(['slug' => $slug])
            ->validate([
                'slug' => 'bail|required|exists:blogs,slug',
                'fullname' => 'bail|required|max:50',
                'email' => 'bail|required|email:rfc,dns',
                'comment' => 'bail|required|max:255'
            ], ['slug.*' => 'Invalid blog entry.']);

        CommentService::create($request->only('slug', 'fullname', 'email', 'comment'));

        return response()->json([
            'status' => 'true',
            'message' => 'Comment added successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

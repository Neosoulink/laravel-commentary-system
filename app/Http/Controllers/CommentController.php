<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($url) {
        return Comment::where('url', base64_decode( $url ) )
        ->whereNull('respond_to_id')
        ->orderBy('created_at', 'DESC')->paginate(3);
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
    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required',
            'url' => 'required'
        ]);

        return auth()->user()->comments()->create([
            'respond_to_id' => $request->respond_to_id,
            'body' => $request->body,
            'url' => $request->url,
        ])->setRelation('user', auth()->user())->setRelation('children', collect());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment) {
        $data = $request->validate([
            'body' => 'required',
            'url' => 'required'
        ]);

        $comment->update($data);
        // $comment->touch();
        return $comment;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment) {
        // $this->dropHasChild($comment);
        $comment->delete();
        return response(null, Response::HTTP_OK);
    }

    private function dropHasChild( Comment $comment) {
        if (!empty($comment->children)) {
            Comment::where('respond_to_id', '=', $comment->id)->onDelete('cascade')->delete();
        }
	}
}

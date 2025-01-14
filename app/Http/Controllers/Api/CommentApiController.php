<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentApiController extends Controller
{
    public function index()
    {
        return Comment::with('book')->get();
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'book_id' => 'required|exists:books,id',
    //         'text' => 'required|string',
    //     ]);

    //     return Comment::create($request->all());
    // }

    public function store(Request $request)
    {
        // if (!auth()->check()) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }

        $request->validate([
            'book_id' => 'required|exists:books,id',
            'content' => 'required|string',
        ]);

        $user = auth()->user();

        $comment = Comment::create([
            //'user_id' => $user->id,
            'user_id' => 3,
            'book_id' => $request->book_id,
            'content' => $request->content, 
        ]);

        return response()->json($comment, 201);
    }



    public function show(Comment $comment)
    {
        return $comment->load('book');
    }




    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => 'string',
        ]);

        $comment->update($request->all());
        return $comment;
    }



    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json(null, 204);
    }
}
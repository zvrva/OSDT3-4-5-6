<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;

class CommentController extends Controller
{
    public function create(Book $book)
    {
        return view('comments.create', compact('book'));
    }

    public function store(Request $request, Book $book)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $book->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        // Определяем, откуда был отправлен запрос
        if ($request->has('redirect_to')) {
            return redirect($request->redirect_to)->with('success', 'Комментарий добавлен!');
        }

        // По умолчанию перенаправляем на страницу с книгами
        return redirect()->route('books.index')->with('success', 'Комментарий добавлен!');
    }


    // public function store(Request $request, Book $book)
    // {
    //     $request->validate([
    //         'content' => 'required|string',
    //     ]);

    //     $book->comments()->create([
    //         'user_id' => auth()->id(),
    //         'content' => $request->content,
    //     ]);

    //     // Перенаправление на страницу с книгами
    //     return redirect()->route('books.index', $book->id)->with('success', 'Комментарий добавлен!');
    // }
}

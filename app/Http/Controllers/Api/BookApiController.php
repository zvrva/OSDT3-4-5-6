<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookApiController extends Controller
{
    public function index()
    {
        return Book::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'author' => 'required|string|max:255',
            'book_title' => 'required|string|max:255',
            'publication_year' => 'required|integer|min:1000|max:2024', 
            'information' => 'required|string',
            'cover_photo' => 'required|string', 
            'additional_information' => 'nullable|string',
        ]);

        // return Book::create($request->all());


        $user = auth()->user();

        $book = Book::create([
            'author' => $request->author,
            'book_title' => $request->book_title,
            'publication_year' => $request->publication_year, 
            'information' => $request->information,
            'cover_photo' => $request->cover_photo, 
            'additional_information' => $request->additional_information,
            'user_id' => 3,
        ]);

        return response()->json($book, 201);
    }

    public function show(Book $book)
    {
        return $book;
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'author' => 'required|string|max:255',
            'book_title' => 'required|string|max:255',
            'publication_year' => 'required|integer|min:1000|max:2024',
            'information' => 'required|string',
            'cover_photo' => 'required|string', 
            'additional_information' => 'nullable|string',
        ]);

        $book->update($request->all());
        return $book;
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json(null, 204);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    // public function index()
    // {
    //     $users = User::all();
    //     return view('users.index', compact('users'));
    // }

    public function index()
    {
        // Получаем всех пользователей, кроме текущего авторизованного
        $users = User::where('id', '!=', auth()->id())->get();

        return view('users.index', compact('users'));
    }

    public function showBooks(string $name)
    {
        $user = User::where('name', $name)->firstOrFail();

        // $books = Book::where('user_id', $user->id)->get();
        $books = Book::where('user_id', $user->id)->with('comments.user')->get();

        return view('users.books', compact('user', 'books'));
    }

    public function feed()
    {
        $friends = auth()->user()->friends;

        $books = Book::whereIn('user_id', $friends->pluck('id'))
                    ->with('user') // Загружаем информацию о пользователе
                    ->orderBy('created_at', 'desc')
                    ->get();

        $comments = Comment::whereIn('user_id', $friends->pluck('id'))
                        ->with('user', 'book') // Загружаем информацию о пользователе и книге
                        ->orderBy('created_at', 'desc')
                        ->get();

        $feedItems = $books->concat($comments)->sortByDesc('created_at');

        return view('users.feed', compact('feedItems'));
    }


    public function profile()
    {
        $tokens = auth()->user()->tokens;
        return view('profile', compact('tokens'));
    }

    // public function generateToken(Request $request)
    // {
    //     $token = $request->user()->createToken($request->token_name);
    //     return redirect()->route('profile')->with('token', $token->plainTextToken);
    // }

    // public function generateToken(Request $request)
    // {
    //     if (!auth()->check()) {
    //         return redirect()->route('login')->with('error', 'Вы должны войти в систему, чтобы создать токен.');
    //     }

    //     $token = $request->user()->createToken($request->token_name);

    //     return redirect()->route('profile')->with('success', 'Токен успешно создан: ' . $token->plainTextToken);
    // }


    public function generateToken(Request $request)
    {
        $token = $request->user()->createToken($request->token_name);
        return redirect()->route('profile')->with('success', 'Токен успешно создан: ' . $token->plainTextToken);
    }
}


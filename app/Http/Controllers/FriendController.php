<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class FriendController extends Controller
{
    public function addFriend(User $user)
    {
        auth()->user()->friends()->attach($user->id);
        $user->friends()->attach(auth()->id()); // Обоюдная дружба

        return redirect()->back()->with('success', 'Пользователь добавлен в друзья!');
    }

    public function removeFriend(User $user)
    {
        auth()->user()->friends()->detach($user->id);
        $user->friends()->detach(auth()->id()); // Удаление обоюдной связи

        return redirect()->back()->with('success', 'Пользователь удален из друзей!');
    }
}
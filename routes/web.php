<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\Api\BookApiController;
use App\Http\Controllers\Api\CommentApiController;





Route::get('/', function () {
    return view('welcome');
});

Route::resource('books', BookController::class);
Route::get('/books', [BookController::class, 'index'])->name('books.index');
// Route::post('/books/{book}/comments', [CommentController::class, 'store'])->name('comments.store');


Route::get('/books/{book}/comments/create', [CommentController::class, 'create'])->name('comments.create');
Route::post('/books/{book}/comments', [CommentController::class, 'store'])->name('comments.store');

Route::post('/friends/{user}/add', [FriendController::class, 'addFriend'])->name('friends.add');
Route::post('/friends/{user}/remove', [FriendController::class, 'removeFriend'])->name('friends.remove');




Route::get('/users', [UserController::class, 'index'])->name('users.index');




// Route::get('/books/{name}', [UserController::class, 'showBooks'])->name('books.user');
// Route::get('/users/{name}/books', [UserController::class, 'showBooks'])->name('books.user');
Route::get('/users/{name}/books', [UserController::class, 'showBooks'])->name('users.books');



Route::get('/feed', [UserController::class, 'feed'])->name('users.feed');



Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
Route::post('/books', [BookController::class, 'store'])->name('books.store');

Route::get('/books/{id}/restore', [BookController::class, 'restore'])->name('books.restore');
Route::delete('/books/{id}/force-delete', [BookController::class, 'forceDelete'])->name('books.forceDelete');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/generate-token', [UserController::class, 'generateToken'])->name('generate.token');
});


Route::post('/generate-token', [UserController::class, 'generateToken'])->name('generate.token');


// Route::get('/profile', [UserController::class, 'profile'])->name('profile');
// Route::post('/generate-token', [UserController::class, 'generateToken'])->name('generate.token');



// Route::apiResource('books', BookApiController::class);
Route::get('/api/books', [BookApiController::class, 'index']);

// Route::apiResource('comments', CommentApiController::class);





Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

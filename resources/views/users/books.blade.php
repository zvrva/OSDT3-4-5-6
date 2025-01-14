<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Книги пользователя {{ $user->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Книги пользователя {{ $user->name }}</h1>

        @if($books->isEmpty())
            <p>У пользователя нет книг.</p>
        @else
            <div class="row">
                @foreach($books as $book)
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">{{ $book->title }}</h5>
                                <p class="card-text">Автор: {{ $book->author }}</p>
                                <p class="card-text">Год публикации: {{ $book->publication_year }}</p>
                                <p class="card-text">{{ $book->information }}</p>

                                <!-- Форма для добавления комментария -->
                                <form action="{{ route('comments.store', $book->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="content">Добавить комментарий:</label>
                                        <textarea name="content" id="content" class="form-control" rows="3" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-2">Отправить</button>
                                </form>

                                <!-- Вывод комментариев -->
                                <h6 class="mt-4">Комментарии:</h6>
                                @foreach($book->comments as $comment)
                                    <div class="comment" style="{{ $comment->user->isFriendWith(auth()->user()) ? 'background-color: yellow;' : '' }}">
                                        <p><strong>{{ $comment->user->name }}</strong>:</p>
                                        <p>{{ $comment->content }}</p>
                                        <p class="text-muted">{{ $comment->created_at->format('d.m.Y H:i') }}</p>
                                    </div>
                                    <hr>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <a href="{{ route('books.index') }}" class="btn btn-primary">Вернуться к списку книг</a>
    </div>
</body>
</html>
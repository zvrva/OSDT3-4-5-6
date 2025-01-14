<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лента пользователя</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Лента пользователя</h1>

        @foreach($feedItems as $item)
            @if($item instanceof \App\Models\Book)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Книга: {{ $item->title }}</h5>
                        <p class="card-text">Автор: {{ $item->author }}</p>
                        <p class="card-text">Год публикации: {{ $item->publication_year }}</p>
                        <p class="card-text">{{ $item->information }}</p>
                        <p class="text-muted">Создано: {{ $item->created_at->format('d.m.Y H:i') }}</p>
                    </div>
                </div>
            @elseif($item instanceof \App\Models\Comment)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Комментарий к книге: {{ $item->book->title }}</h5>
                        <p class="card-text">Автор комментария: {{ $item->user->name }}</p>
                        <p class="card-text">{{ $item->content }}</p>
                        <p class="text-muted">Создано: {{ $item->created_at->format('d.m.Y H:i') }}</p>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</body>
</html>
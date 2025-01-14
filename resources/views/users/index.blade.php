<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список пользователей</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Список пользователей</h1>

        @foreach($users as $user)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $user->name }}</h5>
                    <p class="card-text">Email: {{ $user->email }}</p>

                    <!-- Кнопка для перехода на страницу с книгами пользователя -->
                    <a href="{{ route('users.books', $user->name) }}" class="btn btn-success">Посмотреть книги</a> 

                    <!-- Кнопки для добавления/удаления друзей -->
                    @if(auth()->user()->isFriendWith($user))
                        <form action="{{ route('friends.remove', $user->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger">Удалить из друзей</button>
                        </form>
                    @else
                        <form action="{{ route('friends.add', $user->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-primary">Добавить в друзья</button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach

        <!-- Кнопка для возврата к списку книг авторизованного пользователя -->
        <button id="back-button" class="btn btn-primary" onclick="location.href='{{ route('books.index') }}'" style="background-color:#92A193; color:black; border-color:black">  
            К списку книг авторизованного пользователя
        </button>
    </div>
</body>
</html>

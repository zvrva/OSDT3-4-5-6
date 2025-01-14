<!-- <!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль</title>
</head>
<body>
    <h1>Профиль пользователя</h1>

    <h2>Ваши токены:</h2>
    <ul>
        @foreach($tokens as $token)
            <li>{{ $token->name }} - {{ $token->id }}</li>
        @endforeach
    </ul>

    <h2>Создать новый токен:</h2>
    <form action="{{ route('generate.token') }}" method="POST">
        @csrf
        <input type="text" name="token_name" placeholder="Название токена">
        <button type="submit">Создать токен</button>
    </form>
</body>
</html> -->

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль</title>
</head>
<body>
    <h1>Профиль пользователя</h1>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <h2>Ваши токены:</h2>
    <ul>
        @foreach($tokens as $token)
            <li>{{ $token->name }} - {{ $token->id }}</li>
        @endforeach
    </ul>

    <h2>Создать новый токен:</h2>
    <!-- <form action="{{ route('generate.token') }}" method="POST">
        @csrf
        <input type="text" name="token_name" placeholder="Название токена">
        <button type="submit">Создать токен</button>
    </form> -->
    <form action="{{ route('generate.token') }}" method="POST">
        @csrf
        <input type="text" name="token_name" placeholder="Название токена">
        <button type="submit">Создать токен</button>
    </form>
</body>
</html>
@extends('layouts.app') <!-- Если используется базовый шаблон -->

@section('content')
<div class="container">
    <h1>Список объектов всех пользователей</h1>

    @foreach($users as $user)
        <div class="card mb-3">
            <div class="card-header">
                <h2>{{ $user->name }}</h2>
            </div>
            <div class="card-body">
                <h3>Объекты пользователя:</h3>
                <!-- <ul>
                    @foreach($user->objects as $object)
                        <li>
                            <a href="{{ route('user.objects.show', ['name' => $user->name, 'book' => $book->id]) }}">
                                {{ $object->name }}
                            </a>
                        </li>
                    @endforeach
                </ul> -->

                <ul>
                    @foreach($users as $user)
                        <li>
                            <a href="{{ route('books.user', $user->name) }}">{{ $user->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach
</div>
@endsection


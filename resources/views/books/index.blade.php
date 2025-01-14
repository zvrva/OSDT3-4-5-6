<!DOCTYPE html>
<!-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> -->
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Писатели-фантасты</title>

        <!-- Fonts -->
        <!-- <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet"> -->

        <link type="text/css" rel="stylesheet" href="css/app.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbifELhHTnbk/bQ9p+1+Qcl3zS5/8e0xYSD+Ui/we12xPx5zeijl8JzHmH/T7ZLi6/3nw9l" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    </head>
    <body style="background-color:#FFF0F1">
        <nav>
            <div id="logo">
                <img id="bookmark" src="img/bookmark.png">
            </div>

            <div id="nav_title">
                <h3 class="nav_h3">Энциклопедия фантастов</h3>
            </div>
            <div id="button">
                <button id="add-button" class="btn btn-primary" onclick="location.href='books/create'" style="background-color:#92A193; color:black; border-color:black">  <!-- Updated -->
                    Добавить
                </button>
            </div>
        </nav>


        <div class="container">
            <h1 class="my-1">Библиография</h1>
            <div class="row">
                @foreach ($books as $book)
                <div class="col-12 col-sm-6 col-md-5 col-lg-2">
                    <div class="card" id="card-{{ $loop->iteration }}">
                        <center>
                            <img src="{{ $book->cover_photo }}" class="card-img-top" alt="Изображение {{ $loop->iteration }}" onclick="location.href='{{ route('books.show', $book->id) }}'">
                        </center>
                        <div class="card-img-overlay">
                            <div class="type">Книга</div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">
                                {{ $book->author }} <br>
                                "{{ $book->book_title }}"
                            </h5>
                            <p class="card-text">
                                Год публикации: {{ $book->publication_year}} <br><br>
                                {{ $book->information }}
                            </p>
                        </div>

                        <div class="card-footer d-flex justify-content-between">
                            <a href="{{ route('books.edit', $book->id) }}" class="btn btn-primary" style="border-radius:8px; background-color:#E5B8C1; color:black; border-color:black;">Редактировать</a>
                                <form action="{{ route('books.destroy', $book->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="border-radius:8px; background-color:#E5B8C1; color:black; border-color:black;"  onclick="return confirm('Вы уверены, что хотите удалить эту книгу?')">Удалить</button>
                                </form>
                        </div>
                        <!-- Форма для добавления комментариев -->
                        <!-- <form action="{{ route('comments.store', $book->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="content">Добавить комментарий:</label>
                                <textarea name="content" id="content" class="form-control" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary" style="background-color:#E5B8C1; color:black; border-color:black;">Отправить</button>
                        </form> -->
                        <form action="{{ route('comments.store', $book->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <!-- <label for="content">Добавить комментарий:</label> -->
                                <!-- <textarea name="content" id="content" class="form-control" rows="3" required></textarea> -->
                            </div>
                            <!-- <button type="submit" class="btn btn-primary">Отправить</button> -->
                            <a href="{{ route('comments.create', $book->id) }}" class="btn btn-primary">Добавить комментарий</a>
                        </form>

                        <!-- Вывод комментариев -->
                        <h5 class="mt-4">Комментарии:</h5>
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
                @endforeach
            </div>
            <a href="{{ route('users.index') }}" class="btn btn-primary">Список пользователей</a>
            <a href="{{ route('users.feed') }}" class="btn btn-primary">Лента пользователя</a>
        </div>

        @if(count($trashedBooks))
            <h2>Удалённые книги:</h2>
            <div>
                @foreach ($trashedBooks as $trashBook)
                <div class="col-12 col-sm-6 col-md-5 col-lg-2">
                    <div class="card" id="card-{{ $loop->iteration }}">
                        <center>
                            <img src="{{ $trashBook->cover_photo }}" class="card-img-top" alt="Изображение {{ $loop->iteration }}" onclick="location.href='{{ route('books.show', $trashBook->id) }}'">
                        </center>
                        <div class="card-img-overlay">
                            <div class="type">Удалённая книга</div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">
                                {{ $trashBook->author }} <br>
                                "{{ $trashBook->book_title }}"
                            </h5>
                            <p class="card-text">
                                Год публикации: {{ $trashBook->publication_year}} <br><br>
                                {{ $trashBook->information }}
                            </p>
                        </div>
                        <!-- <div class="card-footer d-flex justify-content-between">
                            @can('restore', $trashBook)
                                <a href="{{ route('books.restore', $trashBook->id) }}" class="btn btn-success" style="border-radius:8px; background-color:#E5B8C1; color:black; border-color:black;">Восстановить</a>
                            @endcan
                        </div> -->
                        <div class="card-footer d-flex justify-content-between">
                            @can('restore', $trashBook)
                                <a href="{{ route('books.restore', $trashBook->id) }}" class="btn btn-success" style="border-radius:8px; background-color:#E5B8C1; color:black; border-color:black;">Восстановить</a>
                            @endcan

                            @can('delete', $trashBook)  
                                <form action="{{ route('books.forceDelete', $trashBook->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"  style="border-radius:8px; background-color:#E5B8C1; color:black; border-color:black;">Удалить полностью</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif



        <footer>
            <p id="footer_p">&copy; Зверева А.</p>
        </footer>

        
        <script src="js/button.js"></script>
        <script src="js/modal.js"></script> 
        <!-- <script src="dist/bundle.js"></script> -->
        

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrM7N5cJH40+1+8a+d3kP7aRWws1U2qbjNl0Pr+15JHODinW+l" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisPd3Yg==" crossorigin="anonymous"></script>
    </body>
</html>
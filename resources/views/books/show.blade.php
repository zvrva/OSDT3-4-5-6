<!DOCTYPE html>
<!-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> -->
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Подробная информация о книге</title>
    </head>
    <body style="background-color:#FFE7EC">
        <div style="margin: 0 auto; width: 800px; border: 2px solid black; padding:10px; border-radius: 10px; background-color:#E1F7E3">
            <h1 class="modal-title" id="modal-title-{{ $book->id }}">
                Подробная информация о книге «{{ $book->book_title }}»
            </h1>
            
            <p>
                {{ $book->additional_information }}
            </p>
            <center>
                <button id="back-button"  onclick="location.href='{{ route('books.index', $book->id) }}'" style="margin-left:50px; margin-right:50px; margin-bottom:10px; border-radius:4px; background-color:#E5B8C1;">
                    Вернуться на главную
                </button>
            </center>
        </div>
    </body>
</html>
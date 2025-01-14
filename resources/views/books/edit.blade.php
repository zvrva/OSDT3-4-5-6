<!-- <form method="POST" action="{{ route('books.update', $book->id) }}" enctype="multipart/form-data">
    @method('PATCH')
    @csrf
    <input type="text" name="book_title" value="{{ old('book_title', $book->book_title) }}"
           placeholder="Название книги">
    <input type="date" name="publication_year" value="{{ old('publication_year', $book->publication_year) }}"
           placeholder="Год публикации">
    <textarea name="information" placeholder="Информация о книге">{{ old('information', $book->information) }}</textarea>
    <input type="file" name="cover_photo">
    <button type="submit">Обновить</button>
</form> -->




<!DOCTYPE html>
<!-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> -->
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Редактирование книги</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
    </head>
    <body style="background-color:#FFE7EC">
    <div style="margin: 0 auto; width: 500px; border: 2px solid black; padding:10px; border-radius: 10px; margin-top:15px; background-color:#E1F7E3">
       <h1>Редактировать книгу</h1>
       <form method="post" action="{{ route('books.update', $book->id) }}" enctype="multipart/form-data"> 
              @csrf
              @method('PUT')
              @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
              <div class="mb-3" style="margin-bottom: 10px;">
                     <label for="author" class="form-label">Автор:</label>
                     <input type="text" class="form-control" id="author" name="author" value="{{ old('author', $book->author) }}" required>
              </div>
              <div class="mb-3" style="margin-bottom: 10px;">
                     <label for="book_title" class="form-label">Название:</label>
                     <input type="text" class="form-control" id="book_title" name="book_title" value="{{ old('book_title', $book->book_title) }}" required>
              </div>
              <div class="mb-3" style="margin-bottom: 10px;">
                     <label for="publication_year" class="form-label">Год публикации:</label>
                     <input type="text" class="form-control" id="publication_year" name="publication_year" value="{{ old('publication_year', $book->publication_year) }}" required>
              </div>
              <div class="mb-3" style="margin-bottom: 10px;">
                     <label for="information" class="form-label">Описание:</label>
                     <textarea class="form-control" id="information" name="information" rows="5">{{ old('information', $book->information) }}</textarea>
              </div>
              <div class="mb-3" style="margin-bottom: 10px;">
                     <label for="additional_information" class="form-label">Дополнительная информация:</label>
                     <textarea class="form-control" id="additional_information" name="additional_information" rows="5">{{ old('additional_information', $book->additional_information) }}</textarea>
              </div>
              <div class="mb-3" style="margin-bottom: 10px;">
                     <label for="cover_photo" class="form-label">Изображение обложки:</label>
                     <input type="file" class="form-control" id="cover_photo" name="cover_photo" accept="image/*">  
              </div>
              <div class="mb-3" style="margin-bottom: 10px;">
                     <label for="image_path">Текущее Изображение:</label>
                     @if ($book->cover_photo)
                            <img src="{{ asset( $book->cover_photo) }}" alt="Текущее изображение" class="img-thumbnail" style="width: 327px; height: 475px; margin-top: 10px;">
                     @else
                            <p>Нет изображения</p>
                     @endif
              </div>
              <!-- <center>
                     <button type="submit" class="btn btn-primary" style="margin-top: 30px; background-color:#b5838d; color:black;">Изменить</button>
              </center> -->

              <div class="card-footer d-flex justify-content-between">
                    <button id="back-button"  onclick="location.href='{{ route('books.index') }}'" class="btn btn-primary" style="margin-top: 30px; background-color:#b5838d; color:black; border-color:black">Вернуться на главную</button>
                    <button type="submit" class="btn btn-primary" style="margin-top: 30px; background-color:#b5838d; color:black;border-color:black">Изменить</button>
                </div>
       </form>
       </div>
       <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>
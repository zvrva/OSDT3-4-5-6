<form action="{{ route('comments.store', $book->id) }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="content">Добавить комментарий:</label>
        <textarea name="content" id="content" class="form-control" rows="3" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Отправить</button>
</form>
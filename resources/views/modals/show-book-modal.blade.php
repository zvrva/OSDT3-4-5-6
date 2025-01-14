<center>
<div class="modal fade" id="modal-{{ $book->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-title-{{ $book->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
                <span aria-hidden="true">×</span>
                </button>
                <h5 class="modal-title" id="modal-title-{{ $book->id }}">
                    Подробная информация о книге «{{ $book->book_title }}»
                </h5>
                
            </div>
            <div class="modal-body">
                <p>
                    {{ $book->additional_information }}
                </p>
            </div>
        </div>
    </div>
</div>
</center>
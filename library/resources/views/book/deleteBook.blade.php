<div style="text-align: center; margin-top: 15%">
    <h2>Apagar Livro</h2>
    <p>Você está apagando o livro: {{ $book->nome }}.</p>

    <form action="{{ route('book.deleteConfirm', $book->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <input type="submit" value="Apagar">
    </form>
    <a href="{{ route('book.view') }}">Voltar</a>
</div>

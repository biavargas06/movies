<div style="text-align: center; margin-top: 15%">
    <h2>Apagar filme</h2>
    <p>Você está apagando o filme: {{ $movie->nome }}.</p>

    <form action="{{ route('movie.deleteConfirm', $movie->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <input type="submit" value="Apagar">
    </form>
    <a href="{{ route('movie.view') }}">Voltar</a>
</div>

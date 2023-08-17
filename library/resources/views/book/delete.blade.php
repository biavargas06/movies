<div style="text-align: center; margin-top: 15%">



    <h2>Apagar Gênero</h2>
    <p>Você está apagando o gênero: {{ $genre->nome}}.</p>

    <form action="{{route('genre.deleteConfirm', $genre->id)}}" method="post">
        @csrf
        @method('delete')

        <input type="submit" value="Apagar"> <br>
        <a href="{{route('genre.view')}}">Voltar</a>

    </form>

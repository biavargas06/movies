<div style="text-align: center; margin-top: 5%">

    <h1>Adicionar Livro</h1>

    @if (session('sucesso'))
        <div>{{ session('sucesso') }}</div>
    @endif

    @if ($errors)
        @foreach ($errors->all() as $erro)
            {{ $erro }} <br>
        @endforeach
    @endif

    <form action="{{ url()->current() }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="nome" placeholder="Título do Livro"><br>
        <input type="number" name="pag" min="5" placeholder="N de páginas"> <br>
        <input type="text" name="autor" placeholder="Nome do Autor"> <br>
        <input type="text" name="editora" placeholder="Nome da Editora"> <br>
        <textarea name="sinopse" cols="40" rows="5" placeholder="Sinopse do livro"></textarea>

        <div>
            <input type="number" name="preco" step="0.01" placeholder="Preço do Livro">
        </div><br>

        <fieldset style="margin-left: 40%; margin-right: 40%">
            <legend style="text-align: left">Data de Publicação:</legend>
            <input type="date" name="ano"> <br>
        </fieldset> <br>

        <div>
            <label for="imagem">Imagem do Livro:</label> <br>
            <input type="file" name="imagem">
        </div> <br>

        <label for="generos">Selecione os gêneros:</label> <br>
        <select name="generos[]" multiple>
            @foreach ($generos as $genero)
                <option value="{{ $genero->id }}">{{ $genero->nome }}</option>
            @endforeach
        </select>
        <br>
        <input type="submit" value="Adicionar">
    </form>

    Gêneros disponíveis <a href="{{ route('genre.view') }}">aqui</a> <br>
    Livros disponíveis <a href="{{ route('book.view') }}">aqui</a> <br>
    <a href="{{ route('home') }}">Voltar</a>
</div>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
        margin: 0;
        padding: 0;
    }

    .container {
        text-align: center;
        margin-top: 5%;
        background-color: #ffffff;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 20px;
        max-width: 500px;
        margin: 0 auto;
        
    }

    h1 {
        margin-top: 0;
        color: #AD9064;
    }

    .success-message {
        color: green;
        font-weight: bold;
    }

    .error-message {
        color: red;
        font-weight: bold;
    }

    form {
        margin-top: 20px;
        text-align: center;

    }

    input[type="text"],
    input[type="number"],
    textarea,
    select {
        width: 80%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box; 
    }

    textarea {
        resize: vertical;
    }

    label {
        font-weight: bold;
    }

    fieldset {
        border: 1px solid #ccc;
        padding: 10px;
        margin: 0;
    }

    legend {
        font-weight: bold;
    }

    input[type="file"] {
        display: flex;
        margin-top: 10px;
        justify-content: center;
        margin-left: 480px;
    }

    input[type="submit"] {
        background-color: #AD9064;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    input[type="submit"]:hover {
        background-color: #94774b;
    }

    .secondary-button {
        background-color: #B392AC;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .secondary-button:hover {
        background-color: #8a577f;
    }

    a {
        color: #AD9064;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }
</style>


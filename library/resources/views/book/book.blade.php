<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sua Página</title>
</head>
<body>

<div class="container">
    @if (session('sucesso'))
    <div>{{ session('sucesso') }}</div>
    @endif

    <form class="search-form" action="{{ url()->current() }}" method="POST">
        @csrf
        <input class="search-input" type="text" name="busca" placeholder="Nome do Livro">
        <button class="search-button" type="submit">Buscar</button>
    </form>

    <table>
        <tr>
            <th>Id</th>
            <th>Nome</th>
            <th>Paginas</th>
            <th>Autor</th>
            <th>Editora</th>
            <th>Ano</th>
            <th colspan="2">Ações</th>
        </tr>

        @foreach ($book as $books)
        <tr>
            <td>{{ $books->id }}</td>
            <td>{{ $books->nome }}</td>
            <td>{{ $books->pag }}</td>
            <td>{{ $books->autor }}</td>
            <td>{{ $books->editora }}</td>
            <td>{{ $books->ano }}</td>
            <td><a href="{{ route('book.edit', $books->id) }}" class="action-link">Editar</a></td>
            <td><a href="{{ route('book.delete', $books->id) }}" class="action-link">Excluir</a></td>
        </tr>
        @endforeach
    </table>

    <a class="back-link" href="{{ route('book') }}">Voltar</a>
</div>

</body>
</html>


<style>
        body {
            margin: 0;
            padding: 0;
            background-color: #ffffff; 
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin-top: 0%;
        }

        .search-form {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
            width: 80%;
        }

        .search-input {
            flex: 1;
            padding: 8px;
            border: 1px solid #8a577f;
        }

        .search-button {
            background-color: #8a577f;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
        }

        .search-button:hover {
            background-color: #b392ac;
        }

        .back-link {
            margin-top: 20px;
            color: #8a577f;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            background-color: #B392AC; 
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #8a577f;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #8a577f;
            color: white;
        }
        

        .action-link {
        color: #8a577f;
        text-decoration: none;
        }


        .action-link:hover {
        text-decoration: none;
        color: purple;
        }


</style>
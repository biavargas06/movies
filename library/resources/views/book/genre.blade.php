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

    <form action="{{ url()->current() }}" method="POST">
        @csrf
        <input type="text" name="busca" placeholder="Buscar Gênero">
        <input type="submit" value="Buscar">
    </form>

    <table>
        <tr>
            <th>Id</th>
            <th>Gênero</th>
        </tr>

        @foreach ($generos as $genero)
        <tr>
            <td>{{ $genero->id }}</td>
            <td>{{ $genero->nome }}</td>
            <td><a href="{{ route('genre.edit', $genero->id) }}">Editar</a></td>
            <td><a href="{{ route('genre.delete', $genero->id) }}">Excluir</a></td>
        </tr>
        @endforeach
    </table>

    Adicione um gênero: <a href="{{ route('genre') }}" class="click">clicando aqui</a> <br>
    <a href="{{ route('book') }}" class="click">Voltar</a>
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

        form {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="submit"] {
            padding: 8px;
            border: 1px solid #AD9064;
            width: 950px; 
        }

        input[type="submit"] {
            background-color: #94774b;
            color: white;
            cursor: pointer;
            width: 10%;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin-bottom: 20px;
            background-color: #AD9064;
        }

        th, td {
            border: 1px solid #94774b;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #94774b;
            color: white;
        }

        a {
            color: #302718;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
            color: #94774b
        }

        .click{
            color: #94774b;
            text-decoration: none;
        }

        .click:hover{
            text-decoration: underline;
            color: #AD9064;
        }
    </style>
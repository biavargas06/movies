<div style="text-align: center; margin-top: 15%">

    <h1>Gerenciar gênero</h1>

    @if (session('sucesso'))
    <div>{{session('sucesso')}}</div>
@endif

    @if ($errors)
    @foreach ($errors->all() as $erro)
        {{$erro}} <br>
        @endforeach
    @endif

    <form action="{{ url()->current()}}" method="POST">
        @csrf
        <input type="text" name="nome" placeholder="Gênero" value="{{old('nome', $genre->nome ?? '')}}"><br>
<br>
        <input type="submit" value="Gravar">
    </form>

    <a href="{{route('genre.view')}}">Voltar</a>
</div>


<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #F0F0F0;
    }

    div {
        text-align: center;
        margin-top: 15%;
        background-color: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        margin-left: 100px;
        margin-right: 100px;
    }

    h1 {
        color: #8A577F;
        margin-bottom: 20px;
    }

    div > label {
        color: #AD9064;
    }

    input[type="text"] {
        width: 100%;
        padding: 10px;
        margin: 5px 0;
        border: 1px solid #AD9064;
        border-radius: 5px;
    }

    input[type="submit"] {
        background-color: #AD9064;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        cursor: pointer;
        font-weight: bold;
    }

    input[type="submit"]:hover {
        background-color: #8A577F;
    }

    a {
        color: #AD9064;
        text-decoration: none;
        margin-top: 10px;
        display: block;
    }

    a:hover {
        color: #8A577F;
    }
</style>

<div style="text-align: center; margin-top: 15%">

    <h1>Cadastro</h1>

    @if ($errors)
    @foreach ($errors->all() as $erro)
        {{$erro}} <br>
        @endforeach
    @endif

    <form action="{{ url()->current()}}" method="POST">
        @csrf
        <input type="text" name="nome" placeholder="Nome"><br>
        <input type="email" name="email" placeholder="Email"> <br>
        <input type="password" name="password" placeholder="Senha">
<br><br>
        <input type="submit" value="Cadastrar">
    </form>

    Já possui uma conta? <a href="{{route('login')}}">Logue aqui</a> <br>
    <a href="{{route('home')}}">Voltar</a>
</div>
<style>
    /* CSS para a página de Cadastro */
body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
}

.container {
    text-align: center;
    margin-top: 15%;
    max-width: 400px;
    margin: 15% auto;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #fff;
}

h1 {
    color: #AD9064;
}

form {
    margin-top: 20px;
}

input[type="text"],
input[type="email"],
input[type="password"] {
    width: 50%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
}

input[type="email"] {
    width: 50%;
}

input[type="password"] {
    width: 50%;
}

input[type="submit"] {
    background-color: #AD9064;
    color: #fff;
    padding: 12px 30px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 15px;
}

input[type="submit"]:hover {
    background-color: #94774b;
}

a {
    color: #B392AC;
    text-decoration: none;
}

a:hover {
    color: #8a577f;
}

div.success {
    color: green;
}

div.error {
    color: red;
}

</style>
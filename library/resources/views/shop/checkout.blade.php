@extends('!layout.layout')

@section('title', 'Livraria Amazing - Checkout')

@section('content')
    <h1>Checkout - Livraria Amazing</h1>

    <h2>Detalhes da Compra:</h2>

    <table border="1">
        <tr>
            <th>Livro</th>
            <th>Preço Unitário</th>
            <th>Quantidade</th>
            <th>Subtotal</th>
        </tr>
        <tr>
            <td>{{ $livro->nome }}</td>
            <td>R$ {{ number_format($livro->preco, 2, ',', '.') }}</td>
            <td>1</td> <!-- Considerando que é uma compra única, a quantidade é sempre 1 -->
            <td>R$ {{ number_format($livro->preco, 2, ',', '.') }}</td> <!-- Subtotal é igual ao preço unitário -->
        </tr>
        <tr>
            <td colspan="3">Total</td>
            <td>R$ {{ number_format($livro->preco, 2, ',', '.') }}</td>
        </tr>
    </table>

    <br>
    <div class="pagar">
        <h2>Método de pagamento:</h2>
        <button>Pix</button>
        <button>Boleto Bancário</button>
        <button>Cartão de Crédito</button>
    </div> <br>

    <form action="{{ route('shop.cancel') }}" method="POST">
        @csrf
        <button type="submit">Cancelar compra</button>
    </form>
    <br>
    <form action="{{ route('shop.finalizarCompra', ['id' => $livro->id]) }}" method="POST">
        @csrf
        <button type="submit" class="finish">Finalizar compra</button>
    </form>

    <style>   
body {
    font-family: Arial, sans-serif;
    background-color: #ffffff;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

h1 {
    color: #AD9064;
    text-align: center;
}

h2 {
    color: #B392AC;
    text-align: center;
}

h3 {
    color: black;
    margin-top: 20px;
    margin-left: 126px;
}

p {
    font-size: 16px; 
    margin-left: 126px; 
}

.pagar {
    text-align: center; 
    margin-top: 20px;
}

.pagar h2 {
    color: #B392AC;
}

table {
    width: 80%;
    border-collapse: collapse;
    margin-top: 20px;
    margin: 20px auto;
}

table, th, td {
    border: 1px solid #AD9064;
}

th, td {
    padding: 10px;
    text-align: center;
}

.button-container {
    display: flex;
    margin-top: 10px;
    justify-content: center;

}

button {
    background-color: #AD9064;
    color: #ffffff;
    border: none;
    padding: 10px 20px;
    margin-right: 10px;
    cursor: pointer;
    border-radius: 5px;
    width: 25.5%;
}

button:hover {
    background-color: #94774b;
}

form {
    text-align: center;
    margin-top: 10px;
}

form button {
    background-color: #B392AC;
    color: #ffffff;
    border: none;
    padding: 10px 20px;
    margin: 5px;
    cursor: pointer;
    border-radius: 5px;
    width: 80%;
}

form button:hover {
    background-color: #8a577f;
}

.finish{
    margin-top: -10px;
}
    </style>

@endsection

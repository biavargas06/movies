@extends('!layout.layout')

@section('title', 'Livraria Amazing')

@section('content')


<head>
    <meta charset="utf-8">
    <title>Livraria Amazing</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>
     
    <h1>Carrinho de Compras</h1>
    @if ($carrinhoItems->count() > 0)
        <table border="1">
            <tr>
                <th></th>
                <th>Livro</th>
                <th>Preço Unitário</th>
                <th>Quantidade</th>
                <th>Subtotal</th>
                <th>Remover</th>
            </tr>
            @foreach ($carrinhoItems as $item)
                <tr>
                    <td>
                        @if ($item->livro->imagem)
                        <img src="{{ asset('storage/' . $item->livro->imagem) }}" alt="{{ $item->livro->nome }}" width="100">
                    @else
                        Sem imagem
                    @endif
                </td>
                    <td>{{ $item->livro->nome }}</td>
                    <td>R$ {{ number_format($item->livro->preco, 2, ',', '.') }}</td>
                    <td>
                        <form action="{{ route('shop.cartUpdate', ['id' => $item->id]) }}" method="POST">
                            @csrf
                            <input type="number" name="quantidade" value="{{ $item->quantidade }}" min="1">
                            <input type="submit" value="Atualizar">
                        </form>
                    </td>
                    <td>R$ {{ number_format($item->livro->preco * $item->quantidade, 2, ',', '.') }}</td>
                    <td>
                        <form action="{{ route('shop.cartRemove', ['id' => $item->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="remover" type="submit"><i class="fa fa-trash" aria-hidden="true"></i>
</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td></td>
                <td colspan="3">Total</td>
                <td>R$ {{ number_format($carrinhoItems->sum(function ($item) {
                    return $item->livro->preco * $item->quantidade;
                }), 2, ',', '.') }}</td>

            </tr>
        </table>

        <!-- Acessando o primeiro item do carrinho para passar o ID do livro para a rota do Checkout -->
        <td>
            <a class="botao-finalizar" href="{{ route('shop.checkoutFromCart', ['id' => $carrinhoItems[0]->livro->id]) }}">Finalizar Compra</a>
        </td>

    @else
        <p>Nenhum item no carrinho.</p>
    @endif
    <link href="css/style.css" rel="stylesheet">

    <style>
    .cart-container {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    h1 {
        text-align: center;
        margin-top: 20px;
    }

    table {
        width: 90%;
        border-collapse: collapse;
        margin: 20px auto;
    }

    th, td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: center;
    }

    th {
        background-color: #f2f2f2;
    }

    img {
        max-width: 100px;
        height: auto;
    }

    form {
        display: inline-block;
    }

    input[type="number"] {
        width: 60px;
        padding: 5px;
    }

    input[type="submit"],
    button {
        background-color: #AD9064;
        color: white;
        padding: 6px 12px;
        border: none;
        cursor: pointer;
        font-size: 14px;
        text-decoration: none;
    }

    input[type="submit"]:hover,
    button:hover {
        background-color: #94774b;
    }

    .remover{
    background-color: #CC314F;
    }

    .remover:hover{
    background-color: red;
    }

.botao-finalizar {
    margin: 0 auto;
    width: 90%;
    display: flex;
    justify-content: center;
    padding: 10px 186px; 
    background-color: #B392AC; 
    color: #fff;
    border-radius: 5px;
    border: 2px solid #B392AC; 
    transition: background-color 0.3s ease; 
    margin-bottom: 20px;
}

.botao-finalizar:hover {
    background-color: #8a577f; 
    border-color: #8a577f; 
    color: #fff;

}



</style>



@endsection

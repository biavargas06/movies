@extends('!layout.layout')

@section('title', 'Livraria Amazing')

@section('content')

@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif



    <div class="container">
        <div class="book-info">
            <div class="book-image">
                @if($books->imagem)
                    <img src="{{ asset('storage/' . $books->imagem) }}" alt="{{ $books->nome }}" width="100">
                @else
                    Sem imagem
                @endif
            </div>
            <div class="book-details">
                <h1>{{ $books->nome }}</h1>
                <p> {{ $books->autor }}</p>
                <fieldset>
                    <legend>Sinopse:</legend>
                    {{ $books->sinopse }}
                </fieldset>
                <p class="sinopse-spacing">Editora: {{ $books->editora }}</p>
                <p>Ano de Publicação: {{ date('Y', strtotime($books->ano)) }}</p>
                <p>N° de páginas: {{ $books->pag }}</p>
                <p>Gênero(s):
                    @if ($books->generos->count() > 0)
                        {{ $books->generos->pluck('nome')->implode(', ') }}
                    @else
                        Nenhum gênero associado
                    @endif
                </p>
            </div>
            <div class="price-box">
                <p>Preço</p>
                <p>R$ {{ $books->preco }}</p>
                <div>
                    <a href="{{ route('shop.checkout', ['id' => $books->id]) }}"  class="buy-button">Comprar</a>
                    <form action="{{ route('shop.cartAdd') }}" method="POST">
                        @csrf
                        <input type="hidden" name="livro_id" value="{{ $books->id }}">
                        <button type="submit" class="add-button">Adicionar ao Carrinho</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



<style>
    body, h1, p, fieldset, img, button {
        margin: 0;
        padding: 0;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #fff;
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f0f0f0;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 35px;
    }

    .book-info {
        display: flex;
    }

    .book-image {
        flex: 0 0 100px;
        margin-right: 20px;
    }

    .book-details {
        flex: 1;
    }

    .sinopse-spacing {
        margin-top: 10px;
    }

    h1 {
        font-size: 28px;
        margin-bottom: 10px;
    }

    img {
        display: block;
        margin-bottom: 10px;
        max-width: 100%;
        height: auto;
    }

    p {
        margin-bottom: 5px;
    }

    fieldset {
        border: 1px solid #ccc;
        padding: 10px;
        margin-top: 15px;
        
    }

    legend {
        font-size: 18px;
        font-weight: bold;
    }
    
    legend{
        margin-bottom: -10px;
    }

    .add-button {
        display: inline-block;
        padding: 10px 20px;
        margin-top: 20px;
        background-color: #AD9064;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .add-button:hover {
        background-color: #94774b;
    }

    .price-box {
        flex: 0 0 120px;
        text-align: center;
        padding: 30px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin: 20px;
    }

    .buy-button {
        display: inline-block;
        padding: 10px 20px;
        margin-top: 20px;
        background-color: #B392AC;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .buy-button:hover {
        background-color: #8a577f;
        color: #fff;

    }

    @media screen and (max-width: 600px) {
        .container {
            padding: 10px;
        }
        .book-info {
            flex-direction: column;
        }
        .book-image {
            margin-right: 0;
            margin-bottom: 10px;
        }
    }

</style>


@endsection

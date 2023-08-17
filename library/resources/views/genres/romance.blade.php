@extends('!layout.layout')

@section('title', 'Livraria Amazing')

@section('content')

@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

    <!-- Navbar Start -->
    <div class="container-fluid mb-5">
        <div class="row border-top px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn shadow-none d-flex align-items-center bg-primary text-white w-100" style="height: 65px; margin-top: 10px; padding: 0 30px;">
                    <h6 class="m-0">Categorias</h6>
                </a>
                <nav class="collapse show navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0" id="navbar-vertical">
                    <div class="navbar-nav w-100 overflow-hidden" style="height:460px">
                        <div class="nav-item dropdown">
                        </div>
                        @foreach ($generos as $genero)
                        <a href="{{ route('livros.genero', ['nome' => $genero->nome]) }}" style="display: block; margin-bottom: 20px; border-bottom: 1px solid #ccc;">{{ $genero->nome }}</a>
            @endforeach
                    </div>
                </nav>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    </button>
                </nav>

    <!-- Featured End -->

    <!-- Products Start -->
    <div class="container-fluid pt-5">
    <div class="text-center mb-4">
    @if ($generoSelecionado)
        <h2>{{ $generoSelecionado->nome }}</h2>
    @endif  
    </div>
    @if ($books instanceof \Illuminate\Database\Eloquent\Collection && $books->count() > 0)
    <div class="row px-xl-5 pb-3">
        @foreach ($books as $book)
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="card product-item border-0 mb-4">
                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                    @if ($book->imagem)
                    <a href="{{ route('book.bookPage', $book->id) }}">
                        <img class="img-fluid w-100" src="{{ asset('storage/' . $book->imagem) }}" alt="{{ $book->nome }}" style="width: 150px; height: 200px; object-fit: cover;">
                    </a>
                    @else
                    Sem imagem
                    @endif
                </div>
                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                    <h6 class="text-truncate mb-3" style="font-size: 14px; margin-left: 2px;"><a href="{{ route('book.bookPage', $book->id) }}">{{ $book->nome }}</a></h6>
                    <div class="d-flex"  style="margin-left: 8px;">
                        <h6>@if ($book->preco)
                            R$ {{ number_format($book->preco, 2, ',', '.') }}
                        @else
                            Preço não definido
                        @endif</h6>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between bg-light border">
                    <form action="{{ route('shop.cartAdd') }}" method="POST">
                        @csrf
                        <input type="hidden" name="livro_id" value="{{ $book->id }}">
                        <button type="submit" class="btn btn-sm text-dark p-0 d-flex justify-content-center align-items-center">Comprar</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    <!-- Products End -->

    @elseif (is_string($books) && !empty($books))
        <p>Nenhum livro encontrado para o gênero: {{ $generoSelecionado->nome }}</p>
    @else
        <p>Nenhum livro encontrado.</p>
    @endif

@endsection

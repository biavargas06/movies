<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Livraria Amazing</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="/css/style.css" rel="stylesheet">
</head>
<body>

    </div> <br><br>

    <div class="row align-items-center py-3 px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a href="{{route('home')}}" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold">
                    <img src="{{ asset('imagens/amazing.png') }}"  style="width: 250px;">
                </h1>
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left">

                <form action="{{ url('/') }}" method="POST">
                @csrf
                    <div class="input-group">
                        <input type="text" name="busca" class="form-control" placeholder="Buscar livro">
                        <div class="input-group-append">
                        </div>
                    </div>
                </form>

            </div>
            <div class="col-lg-3 col-6 text-right">
                <a href="{{route('shop.cart')}}" class="btn border">
                    <i class="fas fas fa-shopping-cart text-primary"></i>
                    <span class="badge">{{$cartItemCount}}</span>
                </a>
                @if (Auth::user())
                <div style="display: inline-block;">
            {{ Auth::user()->nome }} <br>
            <a href="{{ route('logout') }}">Logout</a>
        </div>

            @if (Auth::user() && Auth::user()->isAdmin)
            <a href="{{ route('book') }}">Gerenciar Livros</a>
        @endif
        @else

            <a href="{{ route('login') }}"><i class="fas fas fa-user-circle text-primary"></i></a>
        @endif


            </div>
        </div>
    </div>



    @yield('content')

</body>
</html>

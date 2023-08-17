<?php

use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\filmeController;
use App\Models\Genero;
use App\Models\Carrinho;
use App\Models\filme;
use App\Models\filmeGen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::match(['get', 'post'], '/', function (Request $request) {

    $userId = null;
    if (Auth::check()) {
        $userId = $request->user()->id;
    }
    $cartItemCount = Carrinho::where('usuario_id', '=', $userId)
        ->count();


    $generos = Genero::all();
    $moviesQuery = Filme::query();

    if ($request->isMethod('POST')) {
        $busca = $request->busca;

        // Filtra os movies pelo nome
        $moviesQuery->where('nome', 'LIKE', "%{$busca}%");
    }

    if ($request->has('genero_id')) {
        // Filtra os movies pelo gênero selecionado
        $genero_id = $request->input('genero_id');
        $moviesQuery->whereHas('generos', function ($query) use ($genero_id) {
            $query->where('generos.id', $genero_id); // Especifique a tabela correta usando o alias 'generos.id'
        });
    }

    $movies = $moviesQuery->get();

    // Carregar os gêneros para cada filme encontrado
    $movies->load('generos');

    $movies = Filme::select('movies.id', 'movies.nome', \DB::raw('GROUP_CONCAT(generos.nome SEPARATOR ", ") AS generos'))
        ->join('filme_gens', 'movies.id', '=', 'filme_gens.filme_id')
        ->join('generos', 'filme_gens.genero_id', '=', 'generos.id')
        ->groupBy('movies.id', 'movies.nome')
        ->get();

    // Definir $generoSelecionado como null
    $generoSelecionado = null;

    return view('welcome', compact('movies', 'generos', 'generoSelecionado', 'cartItemCount'))->with('movies', $movies);
})->name('home');

Route::get('/genero/{nome}', [filmeController::class, 'moviesPorGenero'])->name('movies.genero');

Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login');

Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register', [UserController::class, 'regSuccess'])->name('register.addSuccess');

Route::get('/new-movie', [filmeController::class, 'movie'])->name('movie')->middleware('auth');
Route::post('/new-movie', [filmeController::class, 'newmovie'])->name('movie.newmovie');

Route::get('/new-movie/movie/view', [filmeController::class, 'searchmovie'])->name('movie.view')->middleware('auth');
Route::post('/new-movie/movie/view', [filmeController::class, 'searchmovie'])->name('movie.viewTable');

Route::get('/new-movie/movie/movie-page/{movies}', [filmeController::class, 'moviePage'])->name('movie.moviePage');

Route::get('/new-movie/movie/edit/{movies}', [filmeController::class, 'editmovie'])->name('movie.edit')->middleware('auth');
Route::post('/new-movie/movie/edit/{movies}', [filmeController::class, 'editSavemovie'])->name('movie.editSave');

Route::get('/new-movie/movie/delete/{movie}', [filmeController::class, 'deletemovie'])->name('movie.delete')->middleware('auth');
Route::delete('/new-movie/movie/delete/{movie}', [filmeController::class, 'deleteConfirmmovie'])->name('movie.deleteConfirm')->middleware('auth');

Route::get('/new-movie/genre', [filmeController::class, 'genre'])->name('genre')->middleware('auth');
Route::post('/new-movie/genre', [filmeController::class, 'newGenre'])->name('genre.newGenre');

Route::get('/new-movie/genre/new', [filmeController::class, 'search'])->name('genre.view')->middleware('auth');
Route::post('/new-movie/genre/new', [filmeController::class, 'search'])->name('genre.viewTable');

Route::get('/new-movie/genre/edit/{genero}', [filmeController::class, 'edit'])->name('genre.edit')->middleware('auth');
Route::post('/new-movie/genre/edit/{genero}', [filmeController::class, 'editSave'])->name('genre.editSave');

Route::get('/new-movie/genre/delete/{genero}', [filmeController::class, 'delete'])->name('genre.delete')->middleware('auth');
Route::delete('/new-movie/genre/delete/{genero}', [filmeController::class, 'deleteConfirm'])->name('genre.deleteConfirm');

Route::get('/shop/cart', [CarrinhoController::class, 'cartPage'])
    ->name('shop.cart')
    ->middleware('auth');
Route::post('/shop/cart/add', [CarrinhoController::class, 'addToCart'])->name('shop.cartAdd');

Route::post('/shop/cart/update/{id}', [CarrinhoController::class, 'updateCartItem'])->name('shop.cartUpdate');

Route::delete('/shop/cart/remove/{id}', [CarrinhoController::class, 'removeCartItem'])->name('shop.cartRemove');

Route::get('/shop/checkout/{id?}', [CarrinhoController::class, 'checkout'])->name('shop.checkout')->middleware('auth');

Route::get('/shop/checkoutFromCart/{id}', [CarrinhoController::class, 'checkoutFromCart'])->name('shop.checkoutFromCart')->middleware('auth');

Route::post('/shop/cancel', [CarrinhoController::class, 'cancel'])->name('shop.cancel')->middleware('auth');

Route::post('/shop/finalizar-compra/{id}', [CarrinhoController::class, 'checkoutConfirm'])->name('shop.finalizarCompra')->middleware('auth');
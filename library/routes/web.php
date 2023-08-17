<?php

use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LivroController;
use App\Models\Genero;
use App\Models\Carrinho;
use App\Models\Livro;
use App\Models\LivroGen;
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
    $livrosQuery = Livro::query();

    if ($request->isMethod('POST')) {
        $busca = $request->busca;

        // Filtra os livros pelo nome
        $livrosQuery->where('nome', 'LIKE', "%{$busca}%");
    }

    if ($request->has('genero_id')) {
        // Filtra os livros pelo gênero selecionado
        $genero_id = $request->input('genero_id');
        $livrosQuery->whereHas('generos', function ($query) use ($genero_id) {
            $query->where('generos.id', $genero_id); // Especifique a tabela correta usando o alias 'generos.id'
        });
    }

    $books = $livrosQuery->get();

    // Carregar os gêneros para cada livro encontrado
    $books->load('generos');

    $livros = Livro::select('livros.id', 'livros.nome', \DB::raw('GROUP_CONCAT(generos.nome SEPARATOR ", ") AS generos'))
        ->join('livro_gens', 'livros.id', '=', 'livro_gens.livro_id')
        ->join('generos', 'livro_gens.genero_id', '=', 'generos.id')
        ->groupBy('livros.id', 'livros.nome')
        ->get();

    // Definir $generoSelecionado como null
    $generoSelecionado = null;

    return view('welcome', compact('livros', 'generos', 'generoSelecionado', 'cartItemCount'))->with('books', $books);
})->name('home');

Route::get('/genero/{nome}', [LivroController::class, 'livrosPorGenero'])->name('livros.genero');

Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login');

Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register', [UserController::class, 'regSuccess'])->name('register.addSuccess');

Route::get('/new-book', [LivroController::class, 'book'])->name('book')->middleware('auth');
Route::post('/new-book', [LivroController::class, 'newBook'])->name('book.newBook');

Route::get('/new-book/book/view', [LivroController::class, 'searchBook'])->name('book.view')->middleware('auth');
Route::post('/new-book/book/view', [LivroController::class, 'searchBook'])->name('book.viewTable');

Route::get('/new-book/book/book-page/{books}', [LivroController::class, 'bookPage'])->name('book.bookPage');

Route::get('/new-book/book/edit/{books}', [LivroController::class, 'editBook'])->name('book.edit')->middleware('auth');
Route::post('/new-book/book/edit/{books}', [LivroController::class, 'editSaveBook'])->name('book.editSave');

Route::get('/new-book/book/delete/{book}', [LivroController::class, 'deleteBook'])->name('book.delete')->middleware('auth');
Route::delete('/new-book/book/delete/{book}', [LivroController::class, 'deleteConfirmBook'])->name('book.deleteConfirm')->middleware('auth');

Route::get('/new-book/genre', [LivroController::class, 'genre'])->name('genre')->middleware('auth');
Route::post('/new-book/genre', [LivroController::class, 'newGenre'])->name('genre.newGenre');

Route::get('/new-book/genre/new', [LivroController::class, 'search'])->name('genre.view')->middleware('auth');
Route::post('/new-book/genre/new', [LivroController::class, 'search'])->name('genre.viewTable');

Route::get('/new-book/genre/edit/{genero}', [LivroController::class, 'edit'])->name('genre.edit')->middleware('auth');
Route::post('/new-book/genre/edit/{genero}', [LivroController::class, 'editSave'])->name('genre.editSave');

Route::get('/new-book/genre/delete/{genero}', [LivroController::class, 'delete'])->name('genre.delete')->middleware('auth');
Route::delete('/new-book/genre/delete/{genero}', [LivroController::class, 'deleteConfirm'])->name('genre.deleteConfirm');

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
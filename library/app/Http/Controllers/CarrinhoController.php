<?php

namespace App\Http\Controllers;

use App\Models\Carrinho;
use App\Models\Livro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarrinhoController extends Controller
{



    public function cartPage(Request $request)
    {
        $userId = null;
        if (Auth::check()) {
            $userId = $request->user()->id;
        }
        $cartItemCount = Carrinho::where('usuario_id', '=', $userId)
            ->count();
        // Obtém o ID do usuário logado
        $userId = auth()->user()->id;

        // Obtém os itens do carrinho relacionados ao usuário logado
        $carrinhoItems = Carrinho::where('usuario_id', $userId)->get();

        // Carrega os dados dos livros associados aos itens do carrinho
        $carrinhoItems->load('livro');

        return view('shop.cart', compact('carrinhoItems', 'cartItemCount'));
    }


    public function addToCart(Request $request)
    {
        // Verifica se o usuário está autenticado
        if (Auth::check()) {
            $livroId = $request->input('livro_id');
            $quantidade = $request->input('quantidade', 1); // Caso a quantidade não seja fornecida, assume o valor 1

            // Verifica se o livro existe
            $livro = Livro::find($livroId);

            if (!$livro) {
                return redirect()->back()->with('error', 'Livro não encontrado.');
            }

            // Verifica se o livro já está no carrinho do usuário
            $carrinho = Carrinho::where('livro_id', $livroId)
                ->where('usuario_id', Auth::id())
                ->first();

            if ($carrinho) {
                // Se o livro já está no carrinho, incrementa a quantidade
                $quantidade += $carrinho->quantidade;
                $carrinho->update(['quantidade' => $quantidade]);
            } else {
                // Se o livro ainda não está no carrinho, cria um novo registro
                Carrinho::create([
                    'livro_id' => $livroId,
                    'usuario_id' => Auth::id(),
                    'quantidade' => $quantidade,
                ]);
            }

            return redirect()->back()->with('success', 'Livro adicionado ao carrinho com sucesso.');
        } else {
            return redirect()->route('login')->with('error', 'É necessário estar logado para adicionar livros ao carrinho.');
        }
    }

    public function updateCartItem(Request $request, $id)
    {
        // Validação dos campos do formulário
        $request->validate([
            'quantidade' => 'required|integer|min:1',
        ]);

        // Obtém o item do carrinho pelo ID
        $item = Carrinho::find($id);

        // Verifica se o item pertence ao usuário logado
        if ($item && $item->usuario_id == auth()->user()->id) {
            // Atualiza a quantidade do item e salva no banco de dados
            $item->quantidade = $request->quantidade;
            $item->save();
        }

        return redirect()->route('shop.cart');
    }

    public function removeCartItem($id)
    {
        // Obtém o item do carrinho pelo ID
        $item = Carrinho::find($id);

        // Verifica se o item pertence ao usuário logado
        if ($item && $item->usuario_id == auth()->user()->id) {
            // Remove o item do carrinho
            $item->delete();
        }

        return redirect()->route('shop.cart');
    }
    public function checkout($id, Request $request)
    {
        $userId = null;
    if (Auth::check()) {
        $userId = $request->user()->id;
    }
    $cartItemCount = Carrinho::where('usuario_id', '=', $userId)
        ->count();

        // Verifica se o usuário está autenticado
        if (Auth::check()) {
            // Obtém o livro pelo ID
            $livro = Livro::find($id);

            if (!$livro) {
                return redirect()->back()->with('error', 'Livro não encontrado.');
            }

            // Retorna a página de checkout diretamente, passando o livro selecionado
            return view('shop.checkout', compact('livro', 'cartItemCount'));
        } else {
            return redirect()->route('login')->with('error', 'É necessário estar logado para acessar o checkout.');
        }
    }


    public function checkoutFromCart($id, Request $request)
    {

        $userId = null;
        if (Auth::check()) {
            $userId = $request->user()->id;
        }
        $cartItemCount = Carrinho::where('usuario_id', '=', $userId)
            ->count();

        // Verifica se o usuário está autenticado
        if (Auth::check()) {
            // Obtém o ID do usuário logado
            $userId = auth()->user()->id;

            // Obtém os itens do carrinho relacionados ao usuário logado
            $carrinhoItems = Carrinho::where('usuario_id', $userId)->get();

            // Carrega os dados dos livros associados aos itens do carrinho
            $carrinhoItems->load('livro');

            // Calcula o valor total da compra
            $total = $carrinhoItems->sum(function ($item) {
                return $item->livro->preco * $item->quantidade;
            });

            return view('shop.checkoutFromCart', compact('carrinhoItems', 'total', 'cartItemCount'));
        } else {
            // Se o usuário não estiver autenticado, redireciona para a página de login
            return redirect()->route('login')->with('error', 'É necessário estar logado para acessar o checkout.');
        }
    }

    public function addToCartFromWelcome(Request $request)
    {
        // Verifica se o usuário está autenticado
        if (Auth::check()) {
            $livroId = $request->input('livro_id');
            $quantidade = 1; // Você pode alterar a quantidade conforme necessário

            // Verifica se o livro existe
            $livro = Livro::find($livroId);

            if (!$livro) {
                return redirect()->back()->with('error', 'Livro não encontrado.');
            }

            // Verifica se o livro já está no carrinho do usuário
            $carrinho = Carrinho::where('livro_id', $livroId)
                ->where('usuario_id', Auth::id())
                ->first();

            if ($carrinho) {
                // Se o livro já está no carrinho, incrementa a quantidade
                $quantidade += $carrinho->quantidade;
                $carrinho->update(['quantidade' => $quantidade]);
            } else {
                // Se o livro ainda não está no carrinho, cria um novo registro
                Carrinho::create([
                    'livro_id' => $livroId,
                    'usuario_id' => Auth::id(),
                    'quantidade' => $quantidade,
                ]);
            }

            return redirect()->route('shop.cart')->with('success', 'Livro adicionado ao carrinho com sucesso.');
        } else {
            return redirect()->route('login')->with('error', 'É necessário estar logado para adicionar livros ao carrinho.');
        }
    }



    public function cancel(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('home')->with('success', 'Compra cancelada com sucesso.');
        } else {
            return redirect()->route('login')->with('error', 'É necessário estar logado para cancelar a compra.');
        }
    }

    public function checkoutConfirm(Request $request)
    {
        $userId = auth()->user()->id;
        Carrinho::where('usuario_id', $userId)->delete();

        $request->session()->flash('success', 'Compra confirmada com sucesso!');

        return redirect()->route('home');
    }

}
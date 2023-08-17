<?php

namespace App\Http\Controllers;

use App\Models\Carrinho;
use App\Models\Genero;
use App\Models\Filme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FilmeController extends Controller
{



    public function Movie()
    {
        $generos = Genero::all();
        return view('movie.insert', compact('generos'));
    }

    public function newmovie(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|min:3',
            'ano_lancamento' => 'required',
            'sinopse' => 'string|required',
            'url_video' => 'string',
            'imagem' => [
                'image',
                Rule::dimensions()->maxWidth(2048)->maxHeight(2048),
                Rule::file()->max(2048),
            ],
        ]);
        if ($request->hasFile('imagem')) {
            $imagemPath = $request->file('imagem')->store('filme', 'public');
            $dados['imagem'] = $imagemPath;
        } else {
            $dados['imagem'] = '';
        }

        $filme = Filme::create($dados);

        $generoIds = $request->input('generos');
        $filme->generos()->sync($generoIds);

        return redirect()->route('movie')->with('sucesso', 'Filme adicionado com sucesso!');
    }
    public function searchmovie(Request $request)
    {
        if ($request->isMethod('POST')) {
            $busca = $request->busca;

            $movies = Filme::where('nome', 'LIKE', "%{$busca}%")
                ->orWhere('id', $busca)
                ->orderBy('id')
                ->get();
        } else {
            $movies = Filme::all();
        }

        return view('movie.movie', [
            'movie' => $movies,
        ]);
    }
    public function filmePorGenero($nome, Request $request)
    {
        $userId = null;
        if (Auth::check()) {
            $userId = $request->user()->id;
        }
        $cartItemCount = Carrinho::where('usuario_id', '=', $userId)
            ->count();

        $filmesQuery = Filme::query();

        // Filtra os filme pelo gênero selecionado
        $filmeQuery->whereHas('generos', function ($query) use ($nome) {
            $query->where('generos.nome', $nome);
        });

        $movies = $filmeQuery->get();

        // Carregar os gêneros para cada Filme encontrado
        $movies->load('generos');

        $generoSelecionado = Genero::where('nome', $nome)->first();

        // Carregar todos os gêneros
        $generos = Genero::all();

        $filme = Filme::select('filme.id', 'filme.nome', \DB::raw('GROUP_CONCAT(generos.nome SEPARATOR ", ") AS generos'))
            ->join('Filme_gens', 'filme.id', '=', 'Filme_gens.filme_id')
            ->join('generos', 'Filme_gens.genero_id', '=', 'generos.id')
            ->groupBy('filme.id', 'filme.nome')
            ->get();

        $generoSelecionado = Genero::where('nome', $nome)->first();

        return view('genres.' . Str::slug($nome), compact('filme', 'generos', 'movies', 'generoSelecionado', 'cartItemCount'));
    }

    public function moviePage(Filme $movies, Request $request)
    {
        $userId = null;
        if (Auth::check()) {
            $userId = $request->user()->id;
        }
        $cartItemCount = Carrinho::where('usuario_id', '=', $userId)
            ->count();

        $generos = $movies->generos()->pluck('nome')->implode(', ');
        return view('movie.view', compact('movies', 'generos', 'cartItemCount'));
    }

    public function editmovie(Filme $movies)
    {
        $generos = Genero::all();
        return view('movie.insertCopy', [
            'movie' => $movies,
        ], compact('generos'));
    }
    public function editSavemovie(Request $request, Filme $movies)
    {
        $rules = [
            'nome' => [
                'required',
                Rule::unique('filme')->ignore($movies->id),
            ],
            'pag' => 'required|numeric',
            'autor' => 'required',
            'editora' => 'required',
            'ano' => 'required',
            'sinopse' => 'required',
            'preco' => 'required',
        ];

        // Verifica se foi enviada uma nova imagem
        if ($request->hasFile('imagem')) {
            // Se sim, adiciona as regras de validação da imagem
            $rules['imagem'] = [
                'image',
                Rule::dimensions()->maxWidth(2048)->maxHeight(2048),
                Rule::file()->max(2048),
            ];
        }

        $dados = $request->validate($rules);

        if ($request->hasFile('imagem')) {
            // Remove a imagem anterior, caso exista
            if ($movies->imagem) {
                Storage::disk('public')->delete($movies->imagem);
            }

            // Armazena a nova imagem e atualiza o campo no banco de dados
            $imagemPath = $request->file('imagem')->store('filme', 'public');
            $dados['imagem'] = $imagemPath;
        } else {
            // Caso não tenha sido enviada uma nova imagem, mantemos o valor atual
            $dados['imagem'] = $movies->imagem;
        }

        $movies->update($dados);

        // Atualize os gêneros associados ao Filme
        $generoIds = $request->input('generos');
        $movies->generos()->sync($generoIds);

        return redirect()->route('movie.view')->with('sucesso', 'Filme alterado com sucesso!');
    }

    public function deletemovie(Filme $movie)
    {
        return view('movie.deletemovie', [
            'movie' => $movie,
        ]);
    }

    public function deleteConfirmmovie(Filme $movie)
    {
        // Verifica se há registros na tabela 'carrinhos' que referenciam o Filme
        $hasRelatedCarts = Carrinho::where('filme_id', $movie->id)->exists();

        if ($hasRelatedCarts) {
            // Remove os registros do carrinho que referenciam o Filme
            Carrinho::where('filme_id', $movie->id)->delete();
        }

        if ($movie->imagem) {
            // Obtém o caminho completo da imagem no storage
            $imagemPath = 'public/' . $movie->imagem;

            // Verifica se o arquivo existe no storage antes de tentar excluí-lo
            if (Storage::exists($imagemPath)) {
                // Exclui a imagem do storage
                Storage::delete($imagemPath);
            }
        }

        $movie->generos()->detach();
        $movie->delete();

        return redirect()->route('movie.view')->with('sucesso', 'Filme apagado com sucesso!');
    }





    public function genre()
    {
        return view('movie.insertG');
    }

    public function newGenre(Request $form)
    {
        $dados = $form->validate([
            'nome' => 'required|min:3',
        ]);

        Genero::create($dados);
        return redirect()->route('genre')->with('sucesso', 'Gênero adicionado com sucesso!');

    }

    public function search(Request $request)
    {
        if ($request->isMethod('POST')) {
            $busca = $request->busca;

            $genero = Genero::where('nome', 'LIKE', "%{$busca}%")
                ->orWhere('id', $busca)
                ->orderBy('id')
                ->get();
        } else {
            $genero = Genero::all();
        }

        return view('movie.genre', [
            'generos' => $genero,
        ]);
    }

    public function edit(Genero $genero)
    {
        return view('movie.insertG', [
            'genre' => $genero,
        ]);
    }
    public function editSave(Request $form, Genero $genero)
    {
        $dados = $form->validate([
            'nome' => [
                'required',
                Rule::unique('generos')->ignore($genero->id)
            ],
        ]);
        $genero->fill($dados)->save();

        return redirect()->route('genre.view')->with('sucesso', 'Gênero alterado com sucesso!');
    }


    public function delete(Genero $genero)
    {
        return view('movie.delete', [
            'genre' => $genero,
        ]);
    }
    public function deleteConfirm(Genero $genero)
    {
        $genero->delete();

        return redirect()->route('genre.view')->with('sucesso', 'Gênero apagado com sucesso!');
    }

}
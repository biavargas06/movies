<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $user = Usuario::where('email', $request->input('email'))->first();

            if (!$user || !password_verify($request->input('password'), $user->password)) {
                return redirect()->route('login')->with('erro', 'Email ou senha incorretos');
            }

            // Verifica se o usuário é um administrador
            if ($user->isAdmin) {
                // Autenticação como administrador usando o guard 'web' (não é necessário um guard separado para admin)
                Auth::loginUsingId($user->id);

                return redirect()->intended('/'); // Redireciona para o painel de administração
            }

            // Autenticação como usuário normal
            Auth::loginUsingId($user->id);

            return redirect()->intended();
        }

        return view('user.login');
    }


    public function logout()
    {
        Auth::logout();

        return redirect()->route('home');
    }

    public function register()
    {
        return view('user.register');
    }

    public function regSuccess(Request $form)
    {
        $dados = $form->validate([
            'nome' => 'required|min:3',
            'email' => 'required',
            'password' => 'required',
        ]);
        $dados['password'] = Hash::make($dados['password']);

        $user = Usuario::create($dados);

        event(new Registered($user));

        return redirect()->route('login')->with('sucesso', 'Conta Criada com sucesso!');
    }

}
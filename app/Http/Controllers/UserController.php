<?php

namespace App\Http\Controllers;

use App\Models\Links;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index()
    {
        return view('auth');
    }

    public function register(Request $request)
    {
        $info = $request->validate([
            'name' => 'string|required',
            'username' => 'string|required|max:30',
            'email' => 'string|required|email|unique:tbl_users,email', // Correção aqui
            'password' => 'string|required'
        ]);

        // Criptografa a senha antes de salvar!
        $info['password'] = bcrypt($info['password']);

        $user = User::create($info);

        return response()->json(['message' => 'Usuário criado com sucesso!'], 201);
    }

    public function login(Request $request)
    {
        $cred = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if (Auth::attempt($cred)) {
            $user = Auth::user();

            // CRUCIAL: Cria a sessão no navegador para o Blade funcionar
            $request->session()->regenerate();
            Auth::login($user);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'user' => $user
            ]);
        }

        return response()->json(['error' => 'Email ou senha incorreta.'], 401);
    }
}

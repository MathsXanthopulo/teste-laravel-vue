<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Auth/Register', [
            'flash' => [
                'success' => session('success'),
                'error' => session('error'),
                'warning' => session('warning'),
                'info' => session('info')
            ]
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'cnpj' => 'required|string|max:18|unique:users,cnpj',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'company_name.required' => 'O nome da empresa é obrigatório.',
            'company_name.string' => 'O nome da empresa deve ser um texto válido.',
            'company_name.max' => 'O nome da empresa não pode ter mais de 255 caracteres.',
            
            'cnpj.required' => 'O CNPJ é obrigatório.',
            'cnpj.string' => 'O CNPJ deve ser um texto válido.',
            'cnpj.max' => 'O CNPJ não pode ter mais de 18 caracteres.',
            'cnpj.unique' => 'Este CNPJ já está cadastrado.',
            
            'password.required' => 'A senha é obrigatória.',
            'password.confirmed' => 'A confirmação de senha não confere.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
        ]);

        $user = User::create([
            'name' => $request->company_name, // Usar o nome da empresa
            'email' => null, // Email não obrigatório
            'cnpj' => $request->cnpj,
            'company_name' => $request->company_name, // Nome da empresa fornecido
            'phone' => null, // Telefone não obrigatório
            'address' => null, // Endereço não obrigatório
            'city' => null, // Cidade não obrigatória
            'state' => null, // Estado não obrigatório
            'zip_code' => null, // CEP não obrigatório
            'user_type' => 'company',
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return redirect()->route('login')->with('success', 'Conta criada com sucesso! Faça login para continuar.');
    }
}

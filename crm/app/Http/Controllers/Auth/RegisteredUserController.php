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
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'cnpj' => 'required|string|max:18|unique:users,cnpj',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => 'Empresa', // Nome padrão
            'email' => null, // Email não obrigatório
            'cnpj' => $request->cnpj,
            'company_name' => 'Empresa', // Nome padrão
            'phone' => null, // Telefone não obrigatório
            'address' => null, // Endereço não obrigatório
            'city' => null, // Cidade não obrigatória
            'state' => null, // Estado não obrigatório
            'zip_code' => null, // CEP não obrigatório
            'user_type' => 'company',
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // Não fazer login automático - redirecionar para login
        return redirect()->route('login')->with('status', 'Conta criada com sucesso! Faça login para continuar.');
    }
}

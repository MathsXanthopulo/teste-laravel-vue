<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use App\Mail\WelcomeColaboradorMail;
use App\Http\Requests\ColaboradorStoreRequest;
use App\Http\Requests\ColaboradorUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class ColaboradoresController extends Controller
{
    public function index(Request $request): InertiaResponse
    {
        $companyId = Auth::id();
        
        $colaboradores = Colaborador::forCompany($companyId)
            ->orderBy('name')
            ->get()
            ->map(function ($colaborador) {
                return [
                    'id' => $colaborador->id,
                    'name' => $colaborador->name,
                    'email' => $colaborador->email,
                    'phone' => $colaborador->phone,
                    'cargo' => $colaborador->cargo,
                    'departamento' => $colaborador->departamento,
                    'status' => ucfirst($colaborador->status),
                    'dataAdmissao' => $colaborador->data_admissao ? $colaborador->data_admissao->format('d/m/Y') : '-',
                    'salario' => $colaborador->salario ? (float) $colaborador->salario : 0,
                    'salarioFormatado' => $colaborador->salario_formatado,
                ];
            });

        return Inertia::render('Colaboradores/Index', [
            'colaboradores' => $colaboradores,
            'flash' => [
                'success' => session('success'),
                'error' => session('error'),
                'warning' => session('warning'),
                'info' => session('info')
            ]
        ]);
    }

    public function store(ColaboradorStoreRequest $request): RedirectResponse
    {
        $companyId = Auth::id();
        $validated = $request->validated();

        if (!empty($validated['salario'])) {
            $salario = str_replace(['R$', ' ', '.'], ['', '', ''], $validated['salario']);
            $salario = str_replace(',', '.', $salario);
            $validated['salario'] = is_numeric($salario) ? (float) $salario : null;
        }

        $validated['company_id'] = $companyId;
        $validated['status'] = $validated['status'] ?? 'ativo';

        $colaborador = Colaborador::create($validated);

        if ($colaborador->email) {
            try {
                Mail::to($colaborador->email)->send(new WelcomeColaboradorMail($colaborador));
            } catch (\Exception $e) {
                \Log::error('Erro ao enviar email de boas-vindas: ' . $e->getMessage());
            }
        }

        return redirect()->route('colaboradores.index')->with('success', 'Colaborador criado com sucesso!');
    }

    public function update(ColaboradorUpdateRequest $request, int $id): RedirectResponse
    {
        $companyId = Auth::id();
        
        $colaborador = Colaborador::forCompany($companyId)->findOrFail($id);
        
        $validated = $request->validated();

        if (!empty($validated['salario'])) {
            $salario = str_replace(['R$', ' ', '.'], ['', '', ''], $validated['salario']);
            $salario = str_replace(',', '.', $salario);
            $validated['salario'] = is_numeric($salario) ? (float) $salario : null;
        }

        $colaborador->update($validated);

        return redirect()->route('colaboradores.index')->with('success', 'Colaborador atualizado com sucesso!');
    }

    public function destroy(Request $request, int $id): RedirectResponse
    {
        $companyId = Auth::id();
        
        $colaborador = Colaborador::forCompany($companyId)->findOrFail($id);
        $colaborador->delete();

        return redirect()->route('colaboradores.index')->with('success', 'Colaborador excluído com sucesso!');
    }
}
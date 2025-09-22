<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
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
                    'dataAdmissao' => $colaborador->data_admissao?->format('d/m/Y'),
                    'salario' => $colaborador->salario_formatado,
                ];
            });

        return Inertia::render('Colaboradores/Index', [
            'colaboradores' => $colaboradores
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $companyId = Auth::id();
        
        // Debug temporário
        \Log::info('Criando colaborador:', [
            'company_id' => $companyId,
            'user_logged' => Auth::user() ? Auth::user()->toArray() : 'Não logado',
            'request_data' => $request->all()
        ]);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('colaboradores')->where(function ($query) use ($companyId) {
                    return $query->where('company_id', $companyId);
                })
            ],
            'phone' => [
                'nullable',
                'string',
                'max:15',
                Rule::unique('colaboradores')->where(function ($query) use ($companyId) {
                    return $query->where('company_id', $companyId);
                })
            ],
            'cargo' => 'nullable|string|max:255',
            'departamento' => 'nullable|string|max:255',
            'salario' => 'nullable|string',
            'data_admissao' => 'nullable|date',
            'status' => 'nullable|in:ativo,inativo',
        ]);

        // Processar salário se fornecido
        if (!empty($validated['salario'])) {
            // Converter formato brasileiro (R$ 1.000,00) para decimal
            $salario = str_replace(['R$', '.', ' ', ','], ['', '', '', '.'], $validated['salario']);
            $validated['salario'] = is_numeric($salario) ? (float) $salario : null;
        }

        $validated['company_id'] = $companyId;
        $validated['status'] = $validated['status'] ?? 'ativo';

        Colaborador::create($validated);

        return redirect()->route('colaboradores.index')->with('success', 'Colaborador criado com sucesso!');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $companyId = Auth::id();
        
        $colaborador = Colaborador::forCompany($companyId)->findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('colaboradores')->where(function ($query) use ($companyId) {
                    return $query->where('company_id', $companyId);
                })->ignore($id)
            ],
            'phone' => [
                'nullable',
                'string',
                'max:15',
                Rule::unique('colaboradores')->where(function ($query) use ($companyId) {
                    return $query->where('company_id', $companyId);
                })->ignore($id)
            ],
            'cargo' => 'nullable|string|max:255',
            'departamento' => 'nullable|string|max:255',
            'salario' => 'nullable|string',
            'data_admissao' => 'nullable|date',
            'data_demissao' => 'nullable|date',
            'status' => 'nullable|in:ativo,inativo',
        ]);

        // Processar salário se fornecido
        if (!empty($validated['salario'])) {
            // Converter formato brasileiro (R$ 1.000,00) para decimal
            $salario = str_replace(['R$', '.', ' ', ','], ['', '', '', '.'], $validated['salario']);
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
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class ColaboradoresController extends Controller
{
    public function index(Request $request): InertiaResponse
    {
        // Dados mockados para a página
        $colaboradores = [
            [
                'id' => 1,
                'name' => 'João Silva',
                'email' => 'joao.silva@empresa.com',
                'cargo' => 'Desenvolvedor',
                'departamento' => 'TI',
                'status' => 'Ativo',
                'dataAdmissao' => '2023-01-15',
                'salario' => 'R$ 8.500,00',
                'avatar' => 'JS'
            ],
            [
                'id' => 2,
                'name' => 'Maria Santos',
                'email' => 'maria.santos@empresa.com',
                'cargo' => 'Designer',
                'departamento' => 'Marketing',
                'status' => 'Ativo',
                'dataAdmissao' => '2023-03-20',
                'salario' => 'R$ 6.200,00',
                'avatar' => 'MS'
            ],
            [
                'id' => 3,
                'name' => 'Pedro Costa',
                'email' => 'pedro.costa@empresa.com',
                'cargo' => 'Analista',
                'departamento' => 'Financeiro',
                'status' => 'Ativo',
                'dataAdmissao' => '2023-02-10',
                'salario' => 'R$ 7.800,00',
                'avatar' => 'PC'
            ],
            [
                'id' => 4,
                'name' => 'Ana Oliveira',
                'email' => 'ana.oliveira@empresa.com',
                'cargo' => 'Gerente',
                'departamento' => 'Vendas',
                'status' => 'Ativo',
                'dataAdmissao' => '2022-11-05',
                'salario' => 'R$ 12.000,00',
                'avatar' => 'AO'
            ],
            [
                'id' => 5,
                'name' => 'Carlos Ferreira',
                'email' => 'carlos.ferreira@empresa.com',
                'cargo' => 'Assistente',
                'departamento' => 'RH',
                'status' => 'Inativo',
                'dataAdmissao' => '2023-05-12',
                'salario' => 'R$ 4.500,00',
                'avatar' => 'CF'
            ]
        ];

        return Inertia::render('Colaboradores/Index', [
            'colaboradores' => $colaboradores
        ]);
    }

    public function store(Request $request)
    {
        // TODO: validar e criar
        return response()->json(['resource' => 'Colaboradores', 'action' => 'store'], Response::HTTP_CREATED);
    }

    public function update(Request $request, int $id)
    {
        // TODO: validar e atualizar
        return response()->json(['resource' => 'Colaboradores', 'action' => 'update', 'id' => $id]);
    }

    public function destroy(Request $request, int $id)
    {
        // TODO: soft delete
        return response()->json(['resource' => 'Colaboradores', 'action' => 'destroy', 'id' => $id]);
    }
}
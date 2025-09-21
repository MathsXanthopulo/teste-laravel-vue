<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class DashboardController extends Controller
{
    public function index(Request $request): InertiaResponse
    {
        // Estatísticas do dashboard
        $stats = [
            'monthCreated' => 0, // TODO: implementar contagem de funcionários criados no mês
            'monthDeleted' => 0, // TODO: implementar contagem de funcionários demitidos no mês
            'total' => 0, // TODO: implementar contagem total de funcionários ativos
        ];

        return Inertia::render('Dashboard/Page', [
            'stats' => $stats
        ]);
    }

    public function store(Request $request)
    {
        // TODO: validar e criar
        return response()->json(['resource' => 'Dashboard', 'action' => 'store'], Response::HTTP_CREATED);
    }

    public function update(Request $request, int $id)
    {
        // TODO: validar e atualizar
        return response()->json(['resource' => 'Dashboard', 'action' => 'update', 'id' => $id]);
    }

    public function destroy(Request $request, int $id)
    {
        // TODO: soft delete
        return response()->json(['resource' => 'Dashboard', 'action' => 'destroy', 'id' => $id]);
    }
}
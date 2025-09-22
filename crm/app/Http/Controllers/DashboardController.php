<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use App\Models\Colaborador;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request): InertiaResponse
    {
        $user = $request->user();
        
        $monthCreated = Colaborador::forCompany($user->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        
        $monthDeleted = Colaborador::forCompany($user->id)
            ->onlyTrashed()
            ->whereMonth('deleted_at', Carbon::now()->month)
            ->whereYear('deleted_at', Carbon::now()->year)
            ->count();
        
        $totalActive = Colaborador::forCompany($user->id)
            ->where('status', 'ativo')
            ->count();
        
        $lastMonthCreated = Colaborador::forCompany($user->id)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();
        
        $lastMonthDeleted = Colaborador::forCompany($user->id)
            ->onlyTrashed()
            ->whereMonth('deleted_at', Carbon::now()->subMonth()->month)
            ->whereYear('deleted_at', Carbon::now()->subMonth()->year)
            ->count();

        $stats = [
            'monthCreated' => $monthCreated,
            'monthDeleted' => $monthDeleted,
            'totalActive' => $totalActive,
            'lastMonthCreated' => $lastMonthCreated,
            'lastMonthDeleted' => $lastMonthDeleted,
        ];

        return Inertia::render('Dashboard/Page', [
            'stats' => $stats
        ]);
    }

}
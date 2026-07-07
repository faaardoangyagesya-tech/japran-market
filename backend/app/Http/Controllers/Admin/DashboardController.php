<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Game;
use App\Models\Visitor;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAccounts = Account::count();
        $availableAccounts = Account::where('status', 'available')->count();
        $soldAccounts = Account::where('status', 'sold')->count();
        $totalGames = Game::count();
        $totalVisitors = Visitor::count();
        $todayVisitors = Visitor::whereDate('created_at', today())->count();
        $thisWeekVisitors = Visitor::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();

        $mostExpensive = Account::where('status', 'available')
            ->with('game')
            ->orderBy('price', 'desc')
            ->first();

        $accountsByGame = Game::withCount('accounts')->get()->map(function ($game) {
            return [
                'name' => $game->name,
                'total' => $game->accounts_count,
            ];
        });

        $recentAccounts = Account::with('game')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $visitorStats = [
            'daily' => Visitor::whereDate('created_at', today())->count(),
            'weekly' => Visitor::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'monthly' => Visitor::whereMonth('created_at', now()->month)->count(),
            'yearly' => Visitor::whereYear('created_at', now()->year)->count(),
            'total' => $totalVisitors,
        ];

        return response()->json([
            'total_accounts' => $totalAccounts,
            'available_accounts' => $availableAccounts,
            'sold_accounts' => $soldAccounts,
            'total_games' => $totalGames,
            'visitor_stats' => $visitorStats,
            'most_expensive_account' => $mostExpensive ? [
                'code' => $mostExpensive->unique_code,
                'price' => $mostExpensive->price,
                'game' => $mostExpensive->game->name,
            ] : null,
            'accounts_by_game' => $accountsByGame,
            'recent_accounts' => $recentAccounts,
        ]);
    }
}

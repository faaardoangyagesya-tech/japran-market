<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Game;
use App\Models\Visitor;

class StatsController extends Controller
{
    public function index()
    {
        $totalAccounts = Account::count();
        $availableAccounts = Account::where('status', 'available')->count();
        $soldAccounts = Account::where('status', 'sold')->count();
        $totalGames = Game::count();
        $totalVisitors = Visitor::count();
        $todayVisitors = Visitor::whereDate('created_at', today())->count();
        $mostExpensive = Account::where('status', 'available')
            ->with('game')
            ->orderBy('price', 'desc')
            ->first();

        return response()->json([
            'total_accounts' => $totalAccounts,
            'available_accounts' => $availableAccounts,
            'sold_accounts' => $soldAccounts,
            'total_games' => $totalGames,
            'total_visitors' => $totalVisitors,
            'today_visitors' => $todayVisitors,
            'most_expensive_account' => $mostExpensive ? [
                'code' => $mostExpensive->unique_code,
                'price' => $mostExpensive->price,
                'game' => $mostExpensive->game->name,
            ] : null,
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Game;
use App\Http\Resources\AccountResource;

class AccountController extends Controller
{
    public function index($gameSlug)
    {
        $game = Game::where('slug', $gameSlug)->firstOrFail();

        $accounts = Account::where('game_id', $game->id)
            ->available()
            ->with('game')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return AccountResource::collection($accounts);
    }

    public function show($id)
    {
        $account = Account::with('game')->findOrFail($id);

        if ($account->status === 'sold') {
            return response()->json(['message' => 'Akun sudah terjual'], 404);
        }

        return new AccountResource($account);
    }
}

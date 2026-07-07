<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Http\Resources\GameResource;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::withCount(['accounts' => function ($q) {
            $q->where('status', 'available');
        }])->get();

        return GameResource::collection($games);
    }

    public function show($slug)
    {
        $game = Game::where('slug', $slug)
            ->withCount(['accounts' => function ($q) {
                $q->where('status', 'available');
            }])
            ->firstOrFail();

        return new GameResource($game);
    }
}

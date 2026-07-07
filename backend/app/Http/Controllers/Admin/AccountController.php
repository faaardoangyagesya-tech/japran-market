<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Game;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $query = Account::with('game');

        if ($request->game_id) {
            $query->where('game_id', $request->game_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->where('unique_code', 'like', "%{$request->search}%");
        }

        $accounts = $query->orderBy('created_at', 'desc')->paginate(20);

        return response()->json($accounts);
    }

    public function store(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $code = Account::generateUniqueCode();

        $account = Account::create([
            'unique_code' => $code,
            'game_id' => $request->game_id,
            'price' => $request->price,
            'description' => $request->description,
            'status' => 'available',
        ]);

        $account->load('game');

        return response()->json($account, 201);
    }

    public function show($id)
    {
        $account = Account::with('game')->findOrFail($id);
        return response()->json($account);
    }

    public function update(Request $request, $id)
    {
        $account = Account::findOrFail($id);

        $request->validate([
            'game_id' => 'sometimes|exists:games,id',
            'price' => 'sometimes|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'sometimes|in:available,sold',
        ]);

        $account->update($request->only(['game_id', 'price', 'description', 'status']));
        $account->load('game');

        return response()->json($account);
    }

    public function destroy($id)
    {
        $account = Account::findOrFail($id);
        $account->delete();

        return response()->json(['message' => 'Akun berhasil dihapus']);
    }
}

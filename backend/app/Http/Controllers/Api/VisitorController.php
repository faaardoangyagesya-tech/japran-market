<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function store(Request $request)
    {
        $visitor = Visitor::create([
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'page' => $request->input('page', '/'),
        ]);

        $totalVisitors = Visitor::count();
        $todayVisitors = Visitor::whereDate('created_at', today())->count();

        return response()->json([
            'message' => 'ok',
            'total_visitors' => $totalVisitors,
            'today_visitors' => $todayVisitors,
        ]);
    }
}

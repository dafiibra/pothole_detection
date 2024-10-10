<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogActivity;
use Illuminate\Support\Facades\Log;

class LogActivityController extends Controller
{
    public function store(Request $request)
    {
        if (!session()->has('user')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = session('user');

        // Log for checking data before storing
        Log::info('Logging activity', [
            'username' => $user['username'],
            'activity_name' => $request->input('activity_name'),
            'ip_address' => $request->ip()
        ]);

        // Create a log entry
        LogActivity::create([
            'username' => $user['username'],
            'activity_name' => $request->input('activity_name'),
            'ip_address' => $request->ip(),
            'login_time' => now(),
        ]);

        return response()->json(['success' => true]);
    }
}

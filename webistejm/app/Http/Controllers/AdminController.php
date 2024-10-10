<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\inspektor;
use App\Models\LogActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $registrationRequests = DB::table('inspektor')->where('status', 'requested')->get();
        $approvedUsers = DB::table('inspektor')->where('status', 'approved')->get();
        $loginActivities = DB::table('log_activity')->orderBy('login_time', 'desc')->take(10)->get();

        return view('usermanage/user', compact('registrationRequests', 'approvedUsers', 'loginActivities'));
    }

    public function approve($username)
    {
        $user = session('user');
        Log::info('User from session:', (array) $user); // Log session content
        $inspektor = inspektor::findOrFail($username);
        $inspektor->status = 'approved';
        $inspektor->accepted_by = $user->username;
        $inspektor->accepted_timestamp = now();
        $inspektor->save();

        return redirect()->back();
    }

    public function reject($id)
    {
        $user = session('user');
        Log::info('User from session:', (array) $user); // Log session content
        $inspektor = inspektor::findOrFail($id);
        $inspektor->status = 'rejected';
        $inspektor->rejected_by = $user->username;
        $inspektor->rejected_timestamp = now();
        $inspektor->save();

        return redirect()->back();
    }

    public function delete($id)
    {
        $user = session('user');
        Log::info('User from session:', (array) $user); // Log session content
        $inspektor = inspektor::findOrFail($id);
        $inspektor->status = 'rejected';
        $inspektor->save();
        
        return redirect()->back();
    }

    public function viewLoginActivity()
    {
        $activities = LogActivity::all();
        return response()->json($activities);
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogActivity;
use Illuminate\Support\Facades\Auth;
use App\Models\inspektor; // Adjust this according to your actual User model
use Illuminate\Support\Facades\DB;

class UserManagementController extends Controller
{
    public function index()
    {
        // Get the user object from session
        // $username = session('user')->username;

        $registrationRequests = DB::table('inspektor')->where('status', 'requested')->get();
        $approvedUsers = DB::table('inspektor')->where('status', 'approved')->get();
        $loginActivities = DB::table('log_activity')->orderBy('login_time', 'desc')->take(10)->get();

        return view('usermanage/user', compact('registrationRequests', 'approvedUsers', 'loginActivities'));
        //return view('usermanage/user', compact('registrationRequests', 'approvedUsers', 'loginActivities', 'username'));

        
    }

    public function approveUser($id)
    {
        $user = inspektor::findOrFail($id);
        $user->status = 'approved';
        $user->save();

        // You can add a flash message here if needed
        return redirect()->back();
    }

    public function rejectUser($id)
    {
        $user = inspektor::findOrFail($id);
        $user->status = 'rejected';
        $user->save();

        // You can add a flash message here if needed
        return redirect()->back();
    }

}
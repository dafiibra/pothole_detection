<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\DataHasilDeteksi;
use App\Models\Inspeksi;
use DataTables;
use Illuminate\Support\Facades\DB;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class ValidationController extends Controller
{
    function fetch_data(Request $request)
    {
        $user = session('user');

        if($request->ajax()) {
            $dataQuery = DB::table('data_hasil_deteksi')
            ->leftJoin('inspeksi', 'data_hasil_deteksi.id_inspeksi', '=', 'inspeksi.id_inspeksi')
            ->where('data_hasil_deteksi.is_valid', 'requested')
            ->select('data_hasil_deteksi.*', 'inspeksi.tanggal_inspeksi', 'inspeksi.area');
        
            if ($request->area && $request->area != 'All') {
                $dataQuery->where('inspeksi.area', $request->area);
            }
            
            if ($request->from_date && $request->to_date) {
                $startDate = Carbon::parse($request->from_date)->startOfDay();
                $endDate = Carbon::parse($request->to_date)->endOfDay();
                $dataQuery->whereBetween('inspeksi.tanggal_inspeksi', [$startDate, $endDate]);
            }
            
            $data = $dataQuery->get();
            
            return datatables()->of($data)->make(true);
        
        }

        return view('validation', compact('user'));
    }

    public function approveResult($id_deteksi)
    {
        $user = session('user');
        $result = DataHasilDeteksi::findOrFail($id_deteksi);
        $result->is_valid = "approved";
        $result->validated_by = $user->username;
        $result->validated_timestamp = now();   
        $result->save();
        $result->touch();
        
        return response()->json(['success' => true]);
    }

    public function rejectResult($id_deteksi)
    {
        $user = session('user');
        $result = DataHasilDeteksi::findOrFail($id_deteksi);
        $result->is_valid = "rejected";
        $result->validated_by = $user->username;
        $result->validated_timestamp = now();
        $result->save();
        $result->touch();
        return response()->json(['success' => true]);
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\DataHasilDeteksi;
use App\Models\Upload;
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

        $areas = [
            'Sibanceh', 'Binangsa', 'Mebi', 'Belmera', 'MKTT', 'Rapatsar', 'Permai',
            'Palindra', 'Kapalbetung', 'Terpeka', 'Bakter', 'Merak', 'Serpan', 'Serbaraja',
            'Semaraja', 'JORR 3 / Kataraja', 'Pakutan', 'Jagorawi', 'Japek', 'Jalan Layang MBZ',
            'Ulujami-Serpong', 'Akses Tol Bandara', 'JIRR', 'JIRR 2', 'JORR S', 'JORR E', 'JORR W1',
            'JORR W2', 'JORR 2 / CBK', 'JORR 2 / Kunser', 'JORR 2 / Sercin', 'JORR 2 / Cijago',
            'JORR 2 / Cimaci', 'JORR 2 / Cibicil', 'Akses Tanjung Priok', 'Harbour Road II', 'Desari',
            'Becakayu', 'BOSER', 'Sejokara', 'BORR', 'Bocimi', 'Cipularang', 'Padaleunyi', 'Cipali',
            'Palikanci', 'Cijagan', 'Soroja', 'Cisumdawu', 'Japek II Selatan', 'Getaci', 'Pajang',
            'Pematang', 'Batarang', 'Somar', 'Soker', 'Kermo', 'Sumo', 'Surgres', 'Surgem', 'Warunda',
            'KLBM', 'Gempan', 'Mapan', 'Gempas', 'Paspro', 'Probowangi', 'Prolajang', 'Bali Mandara',
            'Tol Bali Barat', 'Balsam', 'Jembatan Teluk Balikpapan', 'Jalan Reformasi', 'Jalan IR Sutami',
            'Tol Layang Pettarani', 'Bima'
        ];

        sort($areas);

        if($request->ajax()) {
            $dataQuery = DB::table('upload')->where('is_valid', 'requested');;
        
            if ($request->area && $request->area != 'All') {
                $dataQuery->where('upload.area', $request->area);
            }
            
            if ($request->from_date && $request->to_date) {
                $startDate = Carbon::parse($request->from_date)->startOfDay();
                $endDate = Carbon::parse($request->to_date)->endOfDay();
                $dataQuery->whereBetween('upload.tanggal', [$startDate, $endDate]);
            }
            
            $data = $dataQuery->get();
            
            return datatables()->of($data)->make(true);
        
        }

        return view('validation', compact('user' , 'areas'));
    }

    public function approveResult($id_deteksi)
    {
        $user = session('user');
        $result = Upload::findOrFail($id_deteksi);
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
        $result = Upload::findOrFail($id_deteksi);
        $result->is_valid = "rejected";
        $result->validated_by = $user->username;
        $result->validated_timestamp = now();
        $result->save();
        $result->touch();
        return response()->json(['success' => true]);
    }
}
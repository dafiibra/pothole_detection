<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inspeksi;
use App\Models\DataHasilDeteksi;
use App\Models\Upload;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // $currentYear = Carbon::now()->year;

        // // Fetch inspeksi data for the current year
        // $inspeksi = Upload::whereYear('tanggal', $currentYear)->get();
        // $inspeksiIds = $inspeksi->pluck('id');
        // $dataHasilDeteksi = Upload::whereIn('id', $inspeksiIds)->get();

        // if (!session()->has('user')) {
        //     return redirect()->route('login')->with('error', 'Session expired, please login again.');
        // }

        // $user = session('user');
        // Log::info('Username from session in DashboardController', ['username' => $user['username']]);

        // List of areas
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

        // Sort areas alphabetically
        sort($areas);

        // // Initialize arrays for metrics
        // $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        // $totalTemuan = array_fill(0, 12, 0);
        // $verified = array_fill(0, 12, 0);
        // $accuracy = array_fill(0, 12, 0);
        // $precision = array_fill(0, 12, 0);
        // $recall = array_fill(0, 12, 0);
        // $monthCounts = array_fill(0, 12, 0);

        // // Calculate metrics
        // foreach ($inspeksi as $inspeksiItem) {
        //     $monthIndex = Carbon::parse($inspeksiItem->tanggal_inspeksi)->month - 1;
        //     $monthTotalTemuan = $dataHasilDeteksi->where('id_inspeksi', $inspeksiItem->id_inspeksi)->count();
        //     $monthVerified = $dataHasilDeteksi->where('id_inspeksi', $inspeksiItem->id_inspeksi)->where('is_valid', 'approved')->count();
        //     $totalTemuan[$monthIndex] += $monthTotalTemuan;
        //     $verified[$monthIndex] += $monthVerified;

        //     $monthJumlahPothole = $inspeksi->where('id_inspeksi', $inspeksiItem->id_inspeksi)->sum('jumlah_pothole');
        //     $accuracy[$monthIndex] += $monthJumlahPothole > 0 ? min(($monthTotalTemuan / $monthJumlahPothole) * 100, 100) : 0;
        //     $precision[$monthIndex] += $monthTotalTemuan > 0 ? min(($monthVerified / $monthTotalTemuan) * 100, 100) : 0;
        //     $recall[$monthIndex] += $monthJumlahPothole > 0 ? min(($monthVerified / $monthJumlahPothole) * 100, 100) : 0;
        //     $monthCounts[$monthIndex]++;
        // }

        // // Average metrics
        // foreach (range(0, 11) as $i) {
        //     if ($monthCounts[$i] > 0) {
        //         $accuracy[$i] = number_format($accuracy[$i] / $monthCounts[$i], 2);
        //         $precision[$i] = number_format($precision[$i] / $monthCounts[$i], 2);
        //         $recall[$i] = number_format($recall[$i] / $monthCounts[$i], 2);
        //     }
        // }

        // $data = [
        //     'totalTemuanModel' => array_sum($totalTemuan),
        //     'truePothole' => array_sum($verified),
        //     'akurasiModel' => count(array_filter($accuracy, fn($value) => $value != 0)) > 0 ? number_format(array_sum($accuracy) / count(array_filter($accuracy, fn($value) => $value != 0)), 2) : 0,
        //     'precision' => count(array_filter($precision, fn($value) => $value != 0)) > 0 ? number_format(array_sum($precision) / count(array_filter($precision, fn($value) => $value != 0)), 2) : 0,
        //     'recall' => count(array_filter($recall, fn($value) => $value != 0)) > 0 ? number_format(array_sum($recall) / count(array_filter($recall, fn($value) => $value != 0)), 2) : 0,
        //     'months' => $months,
        //     'totalTemuan' => $totalTemuan,
        //     'verified' => $verified,
        //     'accuracy' => $accuracy,
        //     'precision' => $precision,
        //     'recall' => $recall,
        // ];

        // return view('dashboard', compact('data', 'areas', 'user'));

        $currentYear = Carbon::now()->year;

        // Fetch data for the current year
        $inspeksi = Upload::whereYear('tanggal', $currentYear)->get();

        // Jumlah laporan yang masuk
        $totalLaporan = $inspeksi->count();

        // Jumlah laporan yang diterima
        $laporanDiterima = $inspeksi->where('is_valid', 'approved')->count();

        // Persentase laporan yang diterima
        $persentaseLaporanDiterima = $totalLaporan > 0 ? number_format(($laporanDiterima / $totalLaporan) * 100, 2) : 0;

        // Matriks jumlah laporan tiap bulan
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June', 
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        $laporanPerBulan = array_fill(0, 12, 0);
        $laporanDiterimaPerBulan = array_fill(0, 12, 0);

        foreach ($inspeksi as $item) {
            $monthIndex = Carbon::parse($item->tanggal)->month - 1;
            $laporanPerBulan[$monthIndex]++;
            if ($item->is_valid === 'approved') {
                $laporanDiterimaPerBulan[$monthIndex]++;
            }
        }

        $data = [
            'totalLaporan' => $totalLaporan,
            'laporanDiterima' => $laporanDiterima,
            'persentaseLaporanDiterima' => $persentaseLaporanDiterima,
            'months' => $months,
            'laporanPerBulan' => $laporanPerBulan,
            'laporanDiterimaPerBulan' => $laporanDiterimaPerBulan,
        ];

        return view('dashboard', compact('data', 'areas'));
    }

    public function filterData(Request $request)
    {
        try {
            $startDate = Carbon::parse($request->input('start_date'));
            $endDate = Carbon::parse($request->input('end_date'));
            $area = $request->input('area');

            Log::info('Filter inputs', ['start_date' => $startDate, 'end_date' => $endDate, 'area' => $area]);

            // Filter inspeksi based on date range and area
            $inspeksiQuery = Upload::whereBetween('tanggal', [$startDate, $endDate]);

            if ($area && $area !== 'All') {
                $inspeksiQuery->where('area', $area);
            }

            $inspeksi = $inspeksiQuery->get();

            Log::info('Inspeksi data', ['inspeksi' => $inspeksi]);

            $inspeksiIds = $inspeksi->pluck('id');
            $dataHasilDeteksi = Upload::whereIn('id', $inspeksiIds)->get();

            Log::info('Data Hasil Deteksi', ['dataHasilDeteksi' => $dataHasilDeteksi]);

            // Initialize arrays for metrics
            $monthsRange = collect([]);
            for ($date = $startDate->copy(); $date->lte($endDate); $date->addMonth()) {
                $monthsRange->push($date->format('F'));
            }
            $totalTemuan = array_fill(0, $monthsRange->count(), 0);
            $verified = array_fill(0, $monthsRange->count(), 0);
            $accuracy = array_fill(0, $monthsRange->count(), 0);
            $precision = array_fill(0, $monthsRange->count(), 0);
            $recall = array_fill(0, $monthsRange->count(), 0);
            $monthCounts = array_fill(0, $monthsRange->count(), 0);

            // Calculate metrics based on filtered data
            foreach ($inspeksi as $inspeksiItem) {
                $monthIndex = $monthsRange->search(Carbon::parse($inspeksiItem->tanggal)->format('F'));
                $monthTotalTemuan = $dataHasilDeteksi->where('id', $inspeksiItem->id)->count();
                $monthVerified = $dataHasilDeteksi->where('id', $inspeksiItem->id)->where('is_valid', 'approved')->count();
                $totalTemuan[$monthIndex] += $monthTotalTemuan;
                $verified[$monthIndex] += $monthVerified;

                $monthJumlahPothole = $inspeksiItem->jumlah_pothole;
                $accuracy[$monthIndex] += $monthJumlahPothole > 0 ? min(($monthTotalTemuan / $monthJumlahPothole) * 100, 100) : 0;
                $precision[$monthIndex] += $monthTotalTemuan > 0 ? min(($monthVerified / $monthTotalTemuan) * 100, 100) : 0;
                $recall[$monthIndex] += $monthJumlahPothole > 0 ? min(($monthVerified / $monthJumlahPothole) * 100, 100) : 0;
                $monthCounts[$monthIndex]++;
            }

            // Average metrics
            foreach (range(0, $monthsRange->count() - 1) as $i) {
                if ($monthCounts[$i] > 0) {
                    $accuracy[$i] = number_format($accuracy[$i] / $monthCounts[$i], 2);
                    $precision[$i] = number_format($precision[$i] / $monthCounts[$i], 2);
                    $recall[$i] = number_format($recall[$i] / $monthCounts[$i], 2);
                }
            }

            $metrics = [
                'totalTemuanModel' => array_sum($totalTemuan),
                'truePothole' => array_sum($verified),
                'akurasiModel' => count(array_filter($accuracy, fn($value) => $value != 0)) > 0 ? number_format(array_sum($accuracy) / count(array_filter($accuracy, fn($value) => $value != 0)), 2) : 0,
                'precision' => count(array_filter($precision, fn($value) => $value != 0)) > 0 ? number_format(array_sum($precision) / count(array_filter($precision, fn($value) => $value != 0)), 2) : 0,
                'recall' => count(array_filter($recall, fn($value) => $value != 0)) > 0 ? number_format(array_sum($recall) / count(array_filter($recall, fn($value) => $value != 0)), 2) : 0,
                'months' => $monthsRange->toArray(),
                'totalTemuan' => $totalTemuan,
                'verified' => $verified,
                'accuracy' => $accuracy,
                'precision' => $precision,
                'recall' => $recall,
            ];

            Log::info('Metrics', ['metrics' => $metrics]);

            return response()->json($metrics);
        } catch (\Exception $e) {
            Log::error('Error filtering data: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}

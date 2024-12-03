<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\DataHasilDeteksi;
use App\Models\Inspeksi;
use App\Models\Upload;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;


class HistoryController extends Controller
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

        if ($request->ajax()) {
            $dataQuery = DB::table('upload')->where('upload.is_valid', 'approved');

            if ($request->area && $request->area != 'All') {
                $dataQuery->where('upload.area', $request->area);
            }

            if ($request->repair_progress != 'All') {
                $dataQuery->where('repair_progress', $request->repair_progress)->where('is_valid', 'approved')->get();
            }

            if ($request->from_date && $request->to_date) {
                $startDate = Carbon::parse($request->from_date)->startOfDay();
                $endDate = Carbon::parse($request->to_date)->endOfDay();
                $dataQuery->whereBetween('upload.tanggal', [$startDate, $endDate]);
            }

            $data = $dataQuery->get();

            return datatables()->of($data)->make(true);
        }

        return view(('history'), compact('user' , 'areas'));
    }

    public function update(Request $request)
    {
        // Validate the input
        $request->validate([
            'id' => 'required|integer|exists:upload,id',
            'progress' => 'required|in:0%,50%,100%',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:40960'
        ]);

        // Find the item by ID
        $item = Upload::findOrFail($request->id);

        // Update the repair progress field
        $progress = $request->input('progress');
        $item->repair_progress = intval(str_replace('%', '', $progress));

        // Handle the image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = '';

            if ($progress === '50%') {
                $path = $file->storeAs('uploads/fiftypct', $filename, 'public');
                $item->fifty_pct_image_url = '/storage/' . $path;
                $item->fifty_pct_update_timestamp = now();
            } elseif ($progress === '100%') {
                $path = $file->storeAs('uploads/onehudpct', $filename, 'public');
                $item->onehud_pct_image_url = '/storage/' . $path;  
                $item->onehud_pct_update_timestamp = now();
            }

            if ($path) {
                $this->compressImageDynamically($file, $path);
            }
        }

        // Save the updated item to the database
        $item->save();

        // update the updated_at
        $item->touch();

        // Return a success response
        return response()->json(['success' => 'Progress updated successfully']);

        // // Validate the input
        // $request->validate([
        //     'id' => 'required|integer|exists:upload,id',
        //     'progress' => 'required|in:0%,50%,100%',
        //     'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:40960'
        // ]);

        // // Find the item by ID
        // $item = Upload::findOrFail($request->id);

        // // Update the repair progress field
        // $progress = $request->input('progress');
        // $item->repair_progress = intval(str_replace('%', '', $progress));

        // // Handle the image upload
        // if ($request->hasFile('image')) {
        //     $file = $request->file('image');
        //     $filename = time() . '_' . $file->getClientOriginalName();
        //     $path = '';

        //     if ($progress === '50%') {
        //         $path = $file->storeAs('uploads/fiftypct', $filename, 'public');
        //         $item->fifty_pct_image_url = '/storage/' . $path;
        //         $item->fifty_pct_update_timestamp = now();
        //     } elseif ($progress === '100%') {
        //         $path = $file->storeAs('uploads/onehudpct', $filename, 'public');
        //         $item->onehud_pct_image_url = '/storage/' . $path;
        //         $item->onehud_pct_update_timestamp = now();
        //     }

        //     if ($path) {
        //         $this->compressImageDynamically($file, $path);
        //     }
        // }

        // // Save the updated item to the database
        // $item->save();

        // // update the updated_at
        // $item->touch();

        // // Return a success response
        // return response()->json(['success' => 'Progress updated successfully']);
    }

    private function compressImageDynamically($file, $path)
    {
        // Get the full path to the stored image
        $fullPath = storage_path('app/public/' . $path);

        // Get the original file size
        $originalFileSize = $file->getSize();

        // Set compression quality based on file size
        if ($originalFileSize > 5000000) { // Greater than 5MB
            $quality = 30;
        } elseif ($originalFileSize > 2000000) { // Between 2MB and 5MB
            $quality = 50;
        } else { // Less than 2MB
            $quality = 70;
        }

        // Use Intervention Image to resize and compress the image
        $image = Image::make($file->getRealPath())
            ->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->save($fullPath, $quality); // Adjust quality dynamically
    }
}

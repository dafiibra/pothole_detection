<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    //
    public function index()
    {
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

        return view('upload', compact('areas'));
    }

    public function store(Request $request)
    {   
        // Validate incoming request data
        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'area' => 'required|string|max:255',
            'image' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048',
            'coordinate' => 'required|string|max:255'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'));
        }

        // Create a new upload record in the database
        // Upload::create([
        //     'tanggal' => $validatedData['tanggal'],
        //     'area' => $validatedData['area'],
        //     'image_url' => $imagePath,
        //     'coordinate' => $validatedData['coordinate']
        // ]);

        $upload = new Upload();
        $upload->tanggal = $validatedData['tanggal'];
        $upload->area = $validatedData['area'];
        $upload->image_url = $imagePath;
        $upload->coordinate = $validatedData['coordinate'];
        $upload->save();

        return redirect()->route('dashboard')->with('success', 'Data berhasil disimpan!');
    }

    /**
     * Handle the image upload and return the storage path.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string
     */
    private function uploadImage($file)
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        return $file->storeAs('uploads', $filename, 'public');
    }
}

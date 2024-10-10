<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspeksi extends Model
{
    use HasFactory;

    protected $table = 'inspeksi';
    protected $primaryKey = 'id_inspeksi';
    protected $fillable = ['jumlah_pothole', 'tanggal_inspeksi', 'video_url', 'area'];

    public function dataHasilDeteksi()
    {
        return $this->hasMany(DataHasilDeteksi::class, 'id_inspeksi', 'id_inspeksi');
    }
}


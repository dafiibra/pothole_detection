<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    use HasFactory;

    protected $table = 'upload';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tanggal',
        'image_url',
        'coordinate',
        'is_valid',
        'area',
        'validated_by',
        'validated_timestamp',
        'repair_progress',
        'fifty_pct_image_url',
        'fifty_pct_update_timestamp',
        'onehud_pct_image_url',
        'onehud_pct_update_timestamp',
    ];
    protected $casts = [
        'validated_timestamp' => 'datetime',
        'fifty_pct_update_timestamp' => 'datetime',
        'onehud_pct_update_timestamp' => 'datetime',
    ];
}

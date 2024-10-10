<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dashboard extends Model
{
    use HasFactory;

    protected $fillable = ['area', 'total_findings', 'verified_findings', 'accuracy', 'precision', 'recall'];
}

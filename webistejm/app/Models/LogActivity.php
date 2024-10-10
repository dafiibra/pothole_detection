<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    protected $table = 'log_activity';

    protected $fillable = [
        'activity_timestamp',
        'activity_name',
        'username',
        'ip_address',
        'login_time'
    ];

    public $timestamps = true;
}

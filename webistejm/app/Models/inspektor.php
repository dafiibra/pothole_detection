<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class inspektor extends  Authenticatable
{
    use HasFactory, Notifiable;
    protected $primaryKey = 'username';
    protected $table = 'inspektor';
    public $incrementing = false; 
    protected $keyType = 'string'; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'fullname',
        'email',
        'division',
        'status',
        'accepted_by',
        'accepted_timestamp',
        'rejected_by',
        'rejected_timestamp',
        'deleted_by',
        'deleted_timestamp',
    ];

    protected $casts = [
        'accepted_timestamp' => 'datetime',
        'rejected_timestamp' => 'datetime',
        'deleted_timestamp' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}

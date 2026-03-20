<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
class Equipment extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'expiry_date',
        'last_maintenance_date',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'last_maintenance_date' => 'date'
    ];

    const EXPIRING_SOON = 'EXPIRING_SOON';
    const EXPIRED = 'EXPIRED';
    const MAINTENANCE_REQUIRED = 'MAINTENANCE_REQUIRED'
}

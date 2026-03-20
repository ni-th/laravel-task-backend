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
    const MAINTENANCE_REQUIRED = 'MAINTENANCE_REQUIRED';

    public function getExpiryAlertAttribute(){
        $today = Carbon::today();
        $expDate = Carbon::parse($this->expiry_date);

        if ($expDate->lt($today)) {
            return self::EXPIRED;
        }

        if ($expDate->diffInDays($today) <= 30) {
            return self::EXPIRING_SOON;
        }

        return null;
    }

    public function getMaintenanceAlertAttribute(){
        $sixMonthAgo = Carbon::now()->subMonth(6);
        $lastMaintenance = Carbon::parse($this->last_maintenance_date);

        if ($lastMaintenance->lt($sixMonthsAgo)) {
            return self::MAINTENANCE_REQUIRED;
        }

        return null;
    }

    public function getAlertsAttribute(){

    $alerts = [];

            if ($expiryAlert = $this->expiry_alert) {
            $alerts[] = $expiryAlert;
        }

        if ($maintenanceAlert = $this->maintenance_alert) {
            $alerts[] = $maintenanceAlert;
        }

        return $alerts;


    }

    // private function getExpiryMessage($status){
    //     return $status === self::EXPIRED 
    //     ? 'This equipment has expired' 
    //     : 'This equipment will expire within 30 days'; 
    // }

    // private function getMaintenanceMessage(){
    //     return "Last maintenance was more than 6 months ago";
    // }
}

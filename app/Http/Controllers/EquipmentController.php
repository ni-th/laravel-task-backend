<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class EquipmentController extends Controller
{

    public function index()
    {
        $equipment = Equipment::all()->map(function ($item) {
            // Calculate alerts for each equipment
            $alerts = [];
            $today = Carbon::today();
            $expiryDate = Carbon::parse($item->expiry_date);
            $sixMonthsAgo = Carbon::now()->subMonths(6);
            $lastMaintenance = Carbon::parse($item->last_maintenance_date);
            
            // Check expiry alerts
            if ($expiryDate->lt($today)) {
                $alerts[] = "EXPIRED";
            } elseif ($expiryDate->diffInDays($today) <= 30) {
                $alerts[] = "EXPIRING_SOON";
            }
            
            // Check maintenance alert
            if ($lastMaintenance->lt($sixMonthsAgo)) {
                $alerts[] = "MAINTENANCE_REQUIRED";
            }
            
            return [
                'asset_id' => $item->id,
                'name' => $item->name,
                'alerts' => $alerts
            ];
        });

        return response()->json($equipment);
    }


    public function show($id)
    {
        $equipment = Equipment::find($id);

        if (!$equipment) {
            return response()->json([
                'error' => 'Equipment not found'
            ], 404);
        }

        // Calculate alerts
        $alerts = [];
        $today = Carbon::today();
        $expiryDate = Carbon::parse($equipment->expiry_date);
        $sixMonthsAgo = Carbon::now()->subMonths(6);
        $lastMaintenance = Carbon::parse($equipment->last_maintenance_date);
        
        // Check expiry alerts
        if ($expiryDate->lt($today)) {
            $alerts[] = "EXPIRED";
        } elseif ($expiryDate->diffInDays($today) <= 30) {
            $alerts[] = "EXPIRING_SOON";
        }
        
        // Check maintenance alert
        if ($lastMaintenance->lt($sixMonthsAgo)) {
            $alerts[] = "MAINTENANCE_REQUIRED";
        }

        return response()->json([
            'asset_id' => $equipment->id,
            'name' => $equipment->name,
            'alerts' => $alerts
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'expiry_date' => 'required|date',
            'last_maintenance_date' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $equipment = Equipment::create($request->all());

        // Calculate alerts for response
        $alerts = [];
        $today = Carbon::today();
        $expiryDate = Carbon::parse($equipment->expiry_date);
        $sixMonthsAgo = Carbon::now()->subMonths(6);
        $lastMaintenance = Carbon::parse($equipment->last_maintenance_date);
        
        if ($expiryDate->lt($today)) {
            $alerts[] = "EXPIRED";
        } elseif ($expiryDate->diffInDays($today) <= 30) {
            $alerts[] = "EXPIRING_SOON";
        }
        
        if ($lastMaintenance->lt($sixMonthsAgo)) {
            $alerts[] = "MAINTENANCE_REQUIRED";
        }

        return response()->json([
            'asset_id' => $equipment->id,
            'name' => $equipment->name,
            'alerts' => $alerts
        ], 201);
    }


    public function update(Request $request, $id)
    {
        $equipment = Equipment::find($id);

        if (!$equipment) {
            return response()->json([
                'error' => 'Equipment not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'expiry_date' => 'sometimes|date',
            'last_maintenance_date' => 'sometimes|date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $equipment->update($request->all());

        // Calculate alerts for response
        $alerts = [];
        $today = Carbon::today();
        $expiryDate = Carbon::parse($equipment->expiry_date);
        $sixMonthsAgo = Carbon::now()->subMonths(6);
        $lastMaintenance = Carbon::parse($equipment->last_maintenance_date);
        
        if ($expiryDate->lt($today)) {
            $alerts[] = "EXPIRED";
        } elseif ($expiryDate->diffInDays($today) <= 30) {
            $alerts[] = "EXPIRING_SOON";
        }
        
        if ($lastMaintenance->lt($sixMonthsAgo)) {
            $alerts[] = "MAINTENANCE_REQUIRED";
        }

        return response()->json([
            'asset_id' => $equipment->id,
            'name' => $equipment->name,
            'alerts' => $alerts
        ]);
    }

    public function destroy($id)
    {
        $equipment = Equipment::find($id);

        if (!$equipment) {
            return response()->json([
                'error' => 'Equipment not found'
            ], 404);
        }

        $equipment->delete();

        return response()->json([
            'message' => 'Equipment deleted successfully'
        ]);
    }

}
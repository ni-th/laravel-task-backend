<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipmentController;

// Equipment routes
Route::get('/equipment', [EquipmentController::class, 'index']);
Route::get('/equipment/{id}', [EquipmentController::class, 'show']);
Route::post('/equipment', [EquipmentController::class, 'store']);
Route::put('/equipment/{id}', [EquipmentController::class, 'update']);
Route::delete('/equipment/{id}', [EquipmentController::class, 'destroy']);
<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventoryController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [UserController::class, 'getProfile']);
    Route::put('/updateProfile/{id}', [UserController::class, 'updateProfile']);
    
    Route::post('/addInventory', [InventoryController::class, 'store']);
    Route::put('/updateInventory/{id}', [InventoryController::class, 'update']);
    Route::delete('/deleteInventory/{id}', [InventoryController::class, 'destroy']);
    Route::get('/inventory', [InventoryController::class, 'index']);
    Route::get('/showInventoryById/{id}', [InventoryController::class, 'show']);
});

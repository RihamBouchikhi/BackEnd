<?php

use App\Http\Controllers\AttestationController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\DemandController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\taskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ProjectController;

// public routes
Route::post('/register', [ProfileController::class,'register']);
Route::POST('/login', [AuthController::class, 'login']);
Route::get('/offers/visible', [OfferController::class,'index']);
Route::get('/offers/{id}', [OfferController::class,'show']);

// protected Routes
Route::middleware('checkorigin')->middleware('auth:sanctum')->group(function () {
    Route::get('/generateAttestation/{id}/{attestation}', [AttestationController::class,'generatAttestation']);
    Route::POST('/logout', [AuthController::class, 'logout']);
    Route::GET('/user', [AuthController::class, 'user']);
    Route::POST('/settings', [GeneralController::class, 'setAppSettings']);
    
    //get all data => projects , admins , tasks ,supervisors , users ( NB data must be pluriel)
    Route::get('/{data}', [GeneralController::class, 'index']);
    Route::get('/{data}/{id}', [GeneralController::class, 'show']);

    //CRUD all profiles Routes
    Route::apiResource('profiles', ProfileController::class);
    Route::post('profiles/{id}/password', [ProfileController::class,'updatePassword']);
    Route::post('/files/{id}', [ProfileController::class,'storeAvatar']);
    //Offers
    Route::apiResource('offers', OfferController::class);
   // Route::middleware('role:user')->group(function () {
        //demands
        Route::apiResource('demands', DemandController::class);
   // });
    //approve rejectDemand
    Route::post('/demands/{id}/{traitement}', [DemandController::class,'accepteDemand']);
    // Project
    Route::apiResource('projects', ProjectController::class);
    //tasks
    Route::apiResource('tasks', taskController::class);
});

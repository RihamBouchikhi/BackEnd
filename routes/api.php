<?php

use App\Http\Controllers\AttestationController;
use App\Http\Controllers\Controller;
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
Route::get('/offers', [OfferController::class,'index']);
Route::get('/offers/{id}', [OfferController::class,'show']);

// protected Routes
Route::middleware('auth:sanctum')->prefix('auth')->group(function () {
    Route::POST('/logout', [AuthController::class, 'logout']);
    Route::GET('/user', [AuthController::class, 'user']);

    Route::get('/generateAttestation/{id}/{attestation}', [AttestationController::class,'generatAttestation']);

    //get all data => projects , admins , tasks ,supervisors , users ( NB data must be pluriel)
    Route::get('/{data}', [Controller::class, 'index']);
    Route::get('/{data}/{id}', [Controller::class, 'show']);


    //CRUD all profiles Routes
    Route::apiResource('profiles', ProfileController::class);
    Route::post('profiles/{id}/password', [ProfileController::class,'updatePassword']);
    Route::post('/files/{id}', [ProfileController::class,'setFile']);

    //Offers
    Route::apiResource('offers', OfferController::class);

    //demand
    Route::apiResource('demands', DemandController::class);

    // Project
    Route::apiResource('projects', ProjectController::class);
    //tasks
    Route::apiResource('tasks', taskController::class);

});

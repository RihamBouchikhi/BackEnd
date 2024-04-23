<?php

use App\Http\Controllers\DemandeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\taskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ProjectController;


//get all data projects , admins , tasks ,supervisors NB data must be pluriel
Route::get('/{data}', [ProfileController::class, 'index']);

//CRUD all profiles Routes
Route::apiResource('profile', ProfileController::class);

//Auth routes
Route::POST('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::POST('/logout', [AuthController::class, 'logout']);
    Route::GET('/user', [AuthController::class, 'user']);
});


//Route::apiResource('offers', OfferController::class);

//Offers
Route::apiResource('offres', OfferController::class);

//Demande
Route::apiResource('demandes', DemandeController::class);

// Projet
Route::apiResource('projects', ProjectController::class);
//tasks
Route::apiResource('tasks', taskController::class);


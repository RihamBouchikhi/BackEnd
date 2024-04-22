<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\InternController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\ProjectController;



//CRUD all profiles Routes
Route::post('/store', [ProfileController::class, 'store']);
Route::put('profile/{id}', [ProfileController::class, 'update']);
Route::delete('profile/{id}', [ProfileController::class, 'destroy']);
Route::get('profile/{id}',[ProfileController::class, 'show']);

//Auth routes
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
});


//Route::apiResource('offers', OfferController::class);

//Offers
Route::post('/offres', [OfferController::class, 'store']);
Route::get('/offres/{id}', [OfferController::class, 'show']);
Route::put('/offres/{id}', [OfferController::class, 'update']);
Route::delete('/offres/{id}', [OfferController::class, 'destroy']);

//Demande

Route::post('/demandes/{offre_id}', [DemandeController::class, 'store']);

// Projet

Route::post('/projects/{supervisorId}', [ProjectController::class, 'store']);



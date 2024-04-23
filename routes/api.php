<?php

use App\Http\Controllers\DemandeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ProjectController;


//get all data projects , admins , tasks ,supervisors NB data must be pluriel
Route::get('/{data}', [ProfileController::class, 'index']);

//CRUD all profiles Routes
Route::POST('/profile', [ProfileController::class, 'store']);
Route::PUT('profile/{id}', [ProfileController::class, 'update']);
Route::DELETE('profile/{id}', [ProfileController::class, 'destroy']);
Route::GET('profile/{id}',[ProfileController::class, 'show']);

//Auth routes
Route::POST('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::POST('/logout', [AuthController::class, 'logout']);
    Route::GET('/user', [AuthController::class, 'user']);
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

Route::post('/projects', [ProjectController::class, 'store']);
Route::get('/projects/{id}', [ProjectController::class, 'show']);
Route::put('/projects/{id}', [ProjectController::class, 'update']);
Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);

Route::post('/projects/{id}/assign-interns', [ProjectController::class, 'assignInterns']);


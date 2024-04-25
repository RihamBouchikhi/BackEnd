<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\DemandController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\taskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ProjectController;

Route::middleware('auth:sanctum')->group(function () {
    Route::POST('/logout', [AuthController::class, 'logout']);
    Route::GET('/user', [AuthController::class, 'user']);
});

Route::post('/register', [ProfileController::class,'register']);
Route::POST('/login', [AuthController::class, 'login']);


//get all data => projects , admins , tasks ,supervisors , users ( NB data must be pluriel)
Route::get('/{data}', [Controller::class, 'index']);
Route::get('/{data}/{id}', [Controller::class, 'show']);

//CRUD all profiles Routes
Route::apiResource('profiles', ProfileController::class);
Route::post('profiles/{id}/password', [ProfileController::class,'updatePassword']);
Route::post('/files/{id}', [ProfileController::class,'setFile']);

//Route::apiResource('offers', OfferController::class);

//Offers
Route::apiResource('offers', OfferController::class);

//demand
Route::apiResource('demands', DemandController::class);

// Projet
Route::apiResource('projects', ProjectController::class);
//tasks
Route::apiResource('tasks', taskController::class);


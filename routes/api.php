<?php

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


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


//Store All profils and users :users admins supervisors interns
//Route::post('/register', [AuthController::class, 'register']);

Route::post('/store', [AuthController::class, 'store']);
Route::post('/update', [AuthController::class, 'update']);
Route::post('/delete', [AuthController::class, 'destroy']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
});

Route::apiResource('users', UserController::class);


// Route pour mettre à jour les informations de l'administrateur
Route::put('/admin/{id}/update', [AdminController::class, 'updateAdmin']);
Route::get('/admin/{id}/show', [AdminController::class, 'showAdmin']);
Route::delete('/admin/{id}/delete', [AdminController::class, 'deleteAdmin']);




// Route pour que l'administrateur crée un compte de stagiaire
Route::put('/intern/{id}/update', [InternController::class, 'updateIntern']);
Route::get('/intern/{id}/show', [InternController::class, 'showIntern']);
Route::delete('/intern/{id}/delete', [InternController::class, 'deleteIntern']);


//Encadrant 

Route::put('/Supervisor/{id}/update', [InternController::class, 'updateSupervisor']);
Route::get('/Supervisor/{id}/show', [InternController::class, 'showSupervisor']);
Route::delete('/Supervisor/{id}/delete', [InternController::class, 'deleteSupervisor']);


//Route::apiResource('offers', OfferController::class);

//Offers
Route::post('/offres', [OfferController::class, 'store']);
Route::get('/offres/{id}', [OfferController::class, 'show']);
Route::put('/offres/{id}', [OfferController::class, 'update']);
Route::delete('/offres/{id}', [OfferController::class, 'destroy']);




// Projet
Route::apiResource('projets', ProjectController::class);



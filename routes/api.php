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


//OffreStage
Route::apiResource('offers', OfferController::class);






// Projet
Route::apiResource('projets', ProjectController::class);










// Route pour les opérations CRUD sur l'entité Equipe













/*
Route::apiResource('administrateur',\App\Http\Controllers\AdminController::class);
Route::post('admin/login',[\App\Http\Controllers\AdminController::class, 'login']);

use App\Http\Controllers\MessageController;

Route::post('/messages', [MessageController::class, 'store']);
Route::get('/messages', [MessageController::class, 'index']);



//Encadrant
Route::apiResource('encadrant',\App\Http\Controllers\SupervisorController::class);
Route::post('encadrant/login',[\App\Http\Controllers\SupervisorController::class, 'login']);


//image upload
Route::post('/images/upload', [ImageController::class, 'upload']);
Route::get('/images', [ImageController::class, 'index']);



//Absence
Route::apiResource('absence',\App\Http\Controllers\AbsenceController::class);

//Attestation
Route::apiResource('attestation',\App\Http\Controllers\AttestationController::class);

//Avancement
Route::apiResource('avancement',\App\Http\Controllers\AvancementController::class);

//Equipe
Route::apiResource('equipe',\App\Http\Controllers\EquipeController::class);

//Etablissment
Route::apiResource('establishment',\App\Http\Controllers\establishmentController::class);

//Mdp_token
Route::apiResource('mdp_token',\App\Http\Controllers\Mdp_tokensController::class);

//Message
Route::apiResource('message',\App\Http\Controllers\MessageController::class);

//participation
Route::apiResource('participation',\App\Http\Controllers\ParticipationController::class);

//Presentation
Route::apiResource('presentation',\App\Http\Controllers\PresentationController::class);

//Projet
Route::apiResource('projet',\App\Http\Controllers\ProjectController::class);

//RapportStage
Route::apiResource('rapportStage',\App\Http\Controllers\RapportStageController::class);

//Reunion
Route::apiResource('reunion',\App\Http\Controllers\ReunionController::class);

//Stage
Route::apiResource('stage',\App\Http\Controllers\StageController::class);

//Stagiaire
Route::apiResource('stagiaire',\App\Http\Controllers\InternController::class);
Route::post('stagiaire/login',[\App\Http\Controllers\InternController::class, 'login']);
Route::get('/equipe/{equipeId}/stagiaires',[\App\Http\Controllers\EquipeController::class, 'getStagiairesByEquipe']);

//Technologie
Route::apiResource('technologie',\App\Http\Controllers\TechnologieController::class);

//User
Route::apiResource('user',\App\Http\Controllers\UserController::class);

//Utilisateur
Route::apiResource('utilisateur',\App\Http\Controllers\UtilisateurController::class);

//establishment
Route::apiResource('establishment',\App\Http\Controllers\establishmentController::class);

//UtilisationTechnologie
Route::apiResource('utilisationTechnologie',\App\Http\Controllers\UtilisationTechnologieController::class);
Route::post('/utilisation-technologie', [UtilisationTechnologieController::class, 'store']);
*/


//UseFull Requests

/*
//getting stagiaires-with-stage
Route::get('/stagiaires-with-stage', [\App\Http\Controllers\InternController::class, 'getStagiairesWithStage']);

//updating stagiaires couvertures
Route::post('/stagiaire/{id}/update-couverture', [\App\Http\Controllers\InternController::class, 'updateCouverture']);

//getting equipes details
Route::get('equipes/details', [\App\Http\Controllers\EquipeController::class, 'getEquipesDetails']);
Route::get('equipes/{equipeId}', [\App\Http\Controllers\EquipeController::class, 'getEquipeDetails']);
//getting an Encadrant equipes
Route::get('/equipes/details/{encadrant_id}', [\App\Http\Controllers\EquipeController::class, 'getEncadrantEquipesDetails']);

//getting Stagiaires Absences
Route::get('/stagiaires/absences', [\App\Http\Controllers\InternController::class, 'getAbsenceStagiaires']);

//getting projects details
Route::get('projet/datails', [\App\Http\Controllers\ProjectController::class, 'getProjetDetails']);


//getting the biggedt id from equipe, administrateur, encadrant, stagiaire


Route::get('/max-id', function () {
    $maxId = max(
        Equipe::max('id'),
        Stagiaire::max('id'),
        Encadrant::max('id'),
        Administrateur::max('id')
    );

    return response()->json(['max_id' => $maxId]);
});






Route::get('stagiaires/{stagiaireId}/projet', [InternController::class, 'getProjetStagiaire']);

Route::get('stagiaire/{stagiaireId}/avancements', [InternController::class, 'getAvancements']);

Route::get('/avancements/{projetId}', [AvancementController::class, 'getAvancementSumByType']);

Route::get('/projet/{projetId}/avancements/this-week', [AvancementController::class,'getAvancementByTypeAndDay']);

Route::get('/projet/{projetId}/avancements/all-time', [AvancementController::class,'getAllTimeAvancement']);

Route::get('projets/details', [\App\Http\Controllers\ProjectController::class, 'getProjetsDetails']);

//getting today absences
Route::get('absences/aujourdhui', [\App\Http\Controllers\AbsenceController::class, 'getAbsencesAujourdhui']);

//Getting 4 last avancements for a specific projet_id
Route::get('/projet/{projet_id}/avancements', [AvancementController::class,'getLastFourAvancements']);

//update equipe id for a specific stagiaire
Route::put('stagiaire/{id}/update-equipe-id', [InternController::class, 'updateEquipeId']);

Route::get('/projet/last-id', [ProjectController::class, 'getLastProjetId']);
*/
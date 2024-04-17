<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdministrateurController;
use App\Http\Controllers\OffresController;
use App\Http\Controllers\FormulaireController;
use App\Http\Controllers\StagiaireController;
use App\Http\Controllers\EncadrantController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\EquipeController;
use App\Http\Controllers\AvancementController;
use App\Models\Equipe;
use App\Models\Stagiaire;
use App\Models\Encadrant;
use App\Models\Administrateur;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Authentification
// Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
// Route::post('/loginAdministrateur', [\App\Http\Controllers\AuthController::class, 'loginAdministrateur']);
// Route::post('/loginEncadrant', [\App\Http\Controllers\AuthController::class, 'loginEncadrant']);
// Route::post('/loginStagiaire', [\App\Http\Controllers\AuthController::class, 'loginStagiaire']);
// Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']);
Route::POST('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
});

Route::apiResource('users', UserController::class);

//Administrateur

// Route pour créer un compte administrateur
Route::post('/admin/create', [AdministrateurController::class, 'createAdmin']);

// Route pour mettre à jour les informations de l'administrateur
Route::put('/admin/{id}/update', [AdministrateurController::class, 'updateAdmin']);


// Route pour que l'administrateur crée un compte de stagiaire
Route::post('/admin/stagiaires/create', [StagiaireController::class, 'createStagiaireByAdmin']);


//OffreStage
Route::apiResource('offres', OffresController::class);
//Route::post('/offers/create', [OffresController::class, 'create']);


//Encadrant 
Route::post('/admin/encadrants/create', [EncadrantController::class, 'createEncadrantByAdmin']);

//Formulaire Condidature

Route::post('/formulaires', [FormulaireController::class, 'store']);


// Projet
Route::apiResource('projets', ProjetController::class);

// Route pour les opérations CRUD sur l'entité Equipe
Route::apiResource('equipes', EquipeController::class)->only(['store', 'show', 'update', 'destroy']);

// Route pour récupérer les stagiaires par date
Route::post('/equipes/stagiaires-by-date', [EquipeController::class, 'getStagiairesByDate']);

// Route pour assigner des stagiaires à une équipe spécifique
Route::post('/equipes/{equipe_id}/assign-stagiaires', [EquipeController::class, 'assignStagiaires']);

// Route pour ajouter des stagiaires à une équipe spécifique
Route::post('/equipes/{equipe_id}/add-stagiaire', [EquipeController::class, 'addStagiaire']);















/*
Route::apiResource('administrateur',\App\Http\Controllers\AdministrateurController::class);
Route::post('admin/login',[\App\Http\Controllers\AdministrateurController::class, 'login']);

use App\Http\Controllers\MessageController;

Route::post('/messages', [MessageController::class, 'store']);
Route::get('/messages', [MessageController::class, 'index']);



//Encadrant
Route::apiResource('encadrant',\App\Http\Controllers\EncadrantController::class);
Route::post('encadrant/login',[\App\Http\Controllers\EncadrantController::class, 'login']);


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
Route::apiResource('etablissement',\App\Http\Controllers\EtablissementController::class);

//Mdp_token
Route::apiResource('mdp_token',\App\Http\Controllers\Mdp_tokensController::class);

//Message
Route::apiResource('message',\App\Http\Controllers\MessageController::class);

//participation
Route::apiResource('participation',\App\Http\Controllers\ParticipationController::class);

//Presentation
Route::apiResource('presentation',\App\Http\Controllers\PresentationController::class);

//Projet
Route::apiResource('projet',\App\Http\Controllers\ProjetController::class);

//RapportStage
Route::apiResource('rapportStage',\App\Http\Controllers\RapportStageController::class);

//Reunion
Route::apiResource('reunion',\App\Http\Controllers\ReunionController::class);

//Stage
Route::apiResource('stage',\App\Http\Controllers\StageController::class);

//Stagiaire
Route::apiResource('stagiaire',\App\Http\Controllers\StagiaireController::class);
Route::post('stagiaire/login',[\App\Http\Controllers\StagiaireController::class, 'login']);
Route::get('/equipe/{equipeId}/stagiaires',[\App\Http\Controllers\EquipeController::class, 'getStagiairesByEquipe']);

//Technologie
Route::apiResource('technologie',\App\Http\Controllers\TechnologieController::class);

//User
Route::apiResource('user',\App\Http\Controllers\UserController::class);

//Utilisateur
Route::apiResource('utilisateur',\App\Http\Controllers\UtilisateurController::class);

//Etablissement
Route::apiResource('etablissement',\App\Http\Controllers\EtablissementController::class);

//UtilisationTechnologie
Route::apiResource('utilisationTechnologie',\App\Http\Controllers\UtilisationTechnologieController::class);
Route::post('/utilisation-technologie', [UtilisationTechnologieController::class, 'store']);
*/


//UseFull Requests

/*
//getting stagiaires-with-stage
Route::get('/stagiaires-with-stage', [\App\Http\Controllers\StagiaireController::class, 'getStagiairesWithStage']);

//updating stagiaires couvertures
Route::post('/stagiaire/{id}/update-couverture', [\App\Http\Controllers\StagiaireController::class, 'updateCouverture']);

//getting equipes details
Route::get('equipes/details', [\App\Http\Controllers\EquipeController::class, 'getEquipesDetails']);
Route::get('equipes/{equipeId}', [\App\Http\Controllers\EquipeController::class, 'getEquipeDetails']);
//getting an Encadrant equipes
Route::get('/equipes/details/{encadrant_id}', [\App\Http\Controllers\EquipeController::class, 'getEncadrantEquipesDetails']);

//getting Stagiaires Absences
Route::get('/stagiaires/absences', [\App\Http\Controllers\StagiaireController::class, 'getAbsenceStagiaires']);

//getting projects details
Route::get('projet/datails', [\App\Http\Controllers\ProjetController::class, 'getProjetDetails']);


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






Route::get('stagiaires/{stagiaireId}/projet', [StagiaireController::class, 'getProjetStagiaire']);

Route::get('stagiaire/{stagiaireId}/avancements', [StagiaireController::class, 'getAvancements']);

Route::get('/avancements/{projetId}', [AvancementController::class, 'getAvancementSumByType']);

Route::get('/projet/{projetId}/avancements/this-week', [AvancementController::class,'getAvancementByTypeAndDay']);

Route::get('/projet/{projetId}/avancements/all-time', [AvancementController::class,'getAllTimeAvancement']);

Route::get('projets/details', [\App\Http\Controllers\ProjetController::class, 'getProjetsDetails']);

//getting today absences
Route::get('absences/aujourdhui', [\App\Http\Controllers\AbsenceController::class, 'getAbsencesAujourdhui']);

//Getting 4 last avancements for a specific projet_id
Route::get('/projet/{projet_id}/avancements', [AvancementController::class,'getLastFourAvancements']);

//update equipe id for a specific stagiaire
Route::put('stagiaire/{id}/update-equipe-id', [StagiaireController::class, 'updateEquipeId']);

Route::get('/projet/last-id', [ProjetController::class, 'getLastProjetId']);
*/
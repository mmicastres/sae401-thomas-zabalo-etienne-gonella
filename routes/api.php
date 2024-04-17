<?php

use App\Http\Controllers\ClassesController;
use App\Http\Controllers\OriginesController;
use App\Http\Controllers\PersonnagesController;
use App\Http\Controllers\RacesController;
use App\Http\Controllers\SousclassesController;
use App\Http\Controllers\SousracesController;
use App\Http\Controllers\CompetencesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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


Route::get('/', function (Request $request) {
    $guide = "Bienvenue dans l'API dédiée à Baldur's Gate 3.
    Cette API vous permet d'accéder à de nombreuses fonctionnalités, nottament la création de personnages.
    POur accéder à la lsite des classes, sousclasses, races, origines, personnages veuillez taper https://zabalo.alwaysdata.net/sae401/api/typedobjetquevouscherchez
    Si vous souhaitez les détails d'un élément en particulier, taper https://zabalo.alwaysdata.net/sae401/api/typeobjetquevouscherchez/iddevotreobjet";
    return response()->json([$guide], 200);
});


// -- gestion des tokens
Route::post('/login', [UserController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [UserController::class, 'logout']);

// Les routes liées aux Users 
Route::middleware(['auth:sanctum', 'abilities:administrateur'])->get('/users', [UserController::class, 'listUsers']);
Route::middleware('auth:sanctum')->get('/users/{id}', [UserController::class, 'detailsUser']);
Route::post('/users', [UserController::class, 'addUser']);
Route::middleware('auth:sanctum')->put('/users/{id}', [UserController::class, 'updateUser']);
Route::middleware('auth:sanctum')->delete('/users/{id}', [UserController::class, 'deleteUser']);



// Les routes liées aux personnages 
Route::get('/personnages', [PersonnagesController::class, 'listPersonnages']);
Route::get('/personnages/{id}', [PersonnagesController::class, 'detailsPersonnage']);
Route::middleware('auth:sanctum')->post('/personnages', [PersonnagesController::class, 'addPersonnage']);
Route::middleware('auth:sanctum')->put('/personnages/{id}', [PersonnagesController::class, 'updatePersonnage']);
Route::middleware('auth:sanctum')->delete('/personnages/{id}', [PersonnagesController::class, 'deletePersonnage']);

// Les routes liées aux Classes

Route::get('/classes', [ClassesController::class, 'listClasses']);
Route::get('/classes/{id}', [ClassesController::class, 'detailsClasse']);
Route::middleware(['auth:sanctum', 'abilities:administrateur'])->post('/classes', [ClassesController::class, 'addClasse']);
Route::middleware(['auth:sanctum', 'abilities:administrateur'])->put('/classes/{id}', [ClassesController::class, 'updateClasse']);
Route::middleware(['auth:sanctum', 'abilities:administrateur'])->delete('/classes/{id}', [ClassesController::class, 'deleteClasse']);

// Les routes liées aux Sousclasses 

Route::get('/sousclasses', [SousclassesController::class, 'listSousclasses']);
Route::get('/sousclasses/{id}', [SousclassesController::class, 'detailsSousClasse']);
Route::middleware(['auth:sanctum', 'abilities:administrateur'])->post('/sousclasses', [SousclassesController::class, 'addSousClasse']);
Route::middleware(['auth:sanctum', 'abilities:administrateur'])->put('/sousclasses/{id}', [SousclassesController::class, 'updateSousClasse']);
Route::middleware(['auth:sanctum', 'abilities:administrateur'])->delete('/sousclasses/{id}', [SousclassesController::class, 'deleteSousClasse']);

// Les routes liées aux Races

Route::get('/races', [RacesController::class, 'listRaces']);
Route::get('/races/{id}', [RacesController::class, 'detailsRace']);
Route::middleware(['auth:sanctum', 'abilities:administrateur'])->post('/races', [RacesController::class, 'addRace']);
Route::middleware(['auth:sanctum', 'abilities:administrateur'])->put('races/{id}', [RacesController::class, 'updateRace']);
Route::middleware(['auth:sanctum', 'abilities:administrateur'])->delete('/races/{id}', [RacesController::class, 'deleteRace']);

// Les routes liées aux Sousraces 

Route::get('/sousraces', [SousracesController::class, 'listSousraces']);
Route::get('/sousraces/{id}', [SousracesController::class, 'detailsSousRace']);
Route::middleware(['auth:sanctum', 'abilities:administrateur'])->post('/sousraces', [SousracesController::class, 'addSousRace']);
Route::middleware(['auth:sanctum', 'abilities:administrateur'])->put('/sousraces/{id}', [SousracesController::class, 'updateSousRace']);
Route::middleware(['auth:sanctum', 'abilities:administrateur'])->delete('/sousraces/{id}', [SousracesController::class, 'deleteSousRace']);

// Les routes liées aux Origines 

Route::get('/origines', [OriginesController::class, 'listOrigines']);
Route::get('/origines/{id}', [OriginesController::class, 'detailsOrigine']);
Route::middleware(['auth:sanctum', 'abilities:administrateur'])->post('/origines', [OriginesController::class, 'addOrigine']);
Route::middleware(['auth:sanctum', 'abilities:administrateur'])->put('/origines/{id}', [OriginesController::class, 'updateOrigine']);
Route::middleware(['auth:sanctum', 'abilities:administrateur'])->delete('/origines/{id}', [OriginesController::class, 'deleteOrigine']);

// Les routes liées aux Competences 

Route::get('/competences', [CompetencesController::class, 'listCompetences']);
Route::get('/competences/{id}', [CompetencesController::class, 'detailsCompetence']);
Route::middleware(['auth:sanctum', 'abilities:administrateur'])->post('/competences', [CompetencesController::class, 'addCompetence']);
Route::middleware(['auth:sanctum', 'abilities:administrateur'])->put('/competences/{id}', [CompetencesController::class, 'updateCompetence']);
Route::middleware(['auth:sanctum', 'abilities:administrateur'])->delete('/competences/{id}', [CompetencesController::class, 'deleteCompetence']);

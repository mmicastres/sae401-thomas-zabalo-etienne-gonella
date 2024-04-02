<?php

use App\Http\Controllers\ClassesController;
use App\Http\Controllers\OriginesController;
use App\Http\Controllers\PersonnagesController;
use App\Http\Controllers\RacesController;
use App\Http\Controllers\SousclassesController;
use App\Http\Controllers\SousracesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

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
    return response()->json(["Bienvenue dans l'API dédiée à Baldur's Gate 3 de la machine virtuelle, ceci est un test"], 200);
});

// -- gestion des tokens
Route::post('/login', function (LoginRequest $request) {
    // -- LoginRequest a verifié que les email et password étaient présents
    // -- il faut maintenant vérifier que les identifiants sont corrects
    $credentials = request(['email', 'password']);
    if (!Auth::attempt($credentials)) {
        return response()->json([
            'status' => 0,
            'message' => 'Utilisateur inexistant ou identifiants incorreccts'
        ], 401);
    }
    // tout est ok, on peut générer le token
    $user = $request->user();
    $tokenResult = $user->createToken('Personal Access Token');
    $token = $tokenResult->plainTextToken;
    return response()->json([
        'status' => 1,
        'accessToken' => $token,
        'token_type' => 'Bearer',
        'user_id' => $user->id
    ]);
});

// Les routes liées aux Users 

Route::middleware('auth:sanctum')->get('/users', [UserController::class, 'listUsers']);
Route::get('/users/{id}', [UserController::class, 'detailsUser']);
Route::post('/users', [UserController::class, 'addUser']);
Route::put('/users/{id}', [UserController::class, 'updateUser']);
Route::delete('/users/{id}', [UserController::class, 'deleteUser']);

// Les routes liées aux personnages 
Route::get('/personnages', [PersonnagesController::class, 'listPersonnages']);
Route::get('/personnages/{id}', [PersonnagesController::class, 'detailsPersonnage']);
Route::post('/personnages', [PersonnagesController::class, 'addPersonnage']);
Route::put('/personnages/{id}', [PersonnagesController::class, 'updatePersonnage']);
Route::delete('/personnages/{id}', [PersonnagesController::class, 'deletePersonnage']);

// Les routes liées aux Classes

Route::get('/classes', [ClassesController::class, 'listClasses']);
Route::get('/classes/{id}', [ClassesController::class, 'detailsClasse']);
Route::post('/classes', [ClassesController::class, 'addClasse']);
Route::put('/classes/{id}', [ClassesController::class, 'updateClasse']);
Route::delete('/classes/{id}', [ClassesController::class, 'deleteClasse']);

// Les routes liées aux Sousclasses 

Route::get('/sousclasses', [SousclassesController::class, 'listSousclasses']);
Route::get('/sousclasses/{id}', [SousclassesController::class, 'detailsSousClasse']);
Route::post('/sousclasses', [SousclassesController::class, 'addSousClasse']);
Route::put('/sousclasses/{id}', [SousclassesController::class, 'updateSousClasse']);
Route::delete('/sousclasses/{id}', [SousclassesController::class, 'deleteSousClasse']);

// Les routes liées aux Races

Route::get('/races', [RacesController::class, 'listRaces']);
Route::get('/races/{id}', [RacesController::class, 'detailsRace']);
Route::post('/races', [RacesController::class, 'addRace']);
Route::put('races/{id}', [RacesController::class, 'updateRace']);
Route::delete('/races/{id}', [RacesController::class, 'deleteRace']);

// Les routes liées aux Sousraces 

Route::get('/sousraces', [SousracesController::class, 'listSousraces']);
Route::get('/sousraces/{id}', [SousracesController::class, 'detailsSousRace']);
Route::post('/sousraces', [SousracesController::class, 'addSousRace']);
Route::put('/sousraces/{id}', [SousracesController::class, 'updateSousRace']);
Route::delete('/sousraces/{id}', [SousracesController::class, 'deleteSousRace']);

// Les routes liées aux Origines 

Route::get('/origines', [OriginesController::class, 'listOrigines']);
Route::get('/origines/{id}', [OriginesController::class, 'detailsOrigine']);
Route::post('/origines', [OriginesController::class, 'addOrigine']);
Route::put('/origines/{id}', [OriginesController::class, 'updateOrigine']);
Route::delete('/origines/{id}', [OriginesController::class, 'deleteOrigine']);

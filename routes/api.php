<?php

use App\Http\Controllers\Classescontroller;
use App\Http\Controllers\OriginesController;
use App\Http\Controllers\PersonnagesController;
use App\Http\Controllers\Sousclassescontroller;
use App\Models\Sousclasses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Les routes liées aux personnages 
Route::get('/personnages', [PersonnagesController::class, 'listPersonnages']);

Route::get('/personnages/{id}', [PersonnagesController::class, 'detailsPersonnage']);

Route::post('/personnages', [PersonnagesController::class, 'addPersonnage']);

Route::put('/personnages/{id}', [PersonnagesController::class, 'updatePersonnage']);

Route::delete('/personnages/{id}', [PersonnagesController::class, 'deletePersonnage']);

// Les routes liées aux Classes

Route::get('/classes', [Classescontroller::class, 'listClasses']);


// Les routes liées aux Sous_classes 

Route::get('/sousclasses', [Sousclassescontroller::class, 'listSousclasses']);


// Les routes liées aux Origines 

Route::get('/origines', [OriginesController::class, 'listOrigines']);

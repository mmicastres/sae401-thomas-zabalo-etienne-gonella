<?php

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
    return response()->json(["message" => "Bienvenue dans l'API dédiée à Baldur's Gate 3 de la machine virtuelle, ceci est un test"], 200);
});

Route::get('/personnages', function (Request $request) {
    return response()->json(["message" => "Ceci est la liste des personnages et ceci est un autre test pour actualisé"], 200);
});
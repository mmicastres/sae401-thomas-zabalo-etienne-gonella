<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Races;

class Racescontroller extends Controller
{
    public function listClasses(Request $request)
    {

        if ($request->has('nom') && !empty($request->nom)) {
            $races = Races::where('nom', 'like', '%' . $request->nom . '%')->get();
            return response()->json($races);
        } else {
            $races = Races::with('sousraces', 'personnages')->orderby('id', 'desc')->get();
            return response()->json($races, 200);
        }
    }
}

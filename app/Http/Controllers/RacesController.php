<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Races;

class RacesController extends Controller
{
    public function listRaces(Request $request)
    {

        if ($request->has('nom') && !empty($request->nom)) {
            $races = Races::where('nom', 'like', '%' . $request->nom . '%')->get();
            return response()->json($races);
        } else {
            $races = Races::with('sousraces')->orderby('id', 'desc')->get();
            return response()->json($races, 200);
        }
    }

    public function detailsRace(Request $request)
    {
        $race = Races::where("id", "=", $request->id)->get();
        return response()->json($race, 200);
    }
}

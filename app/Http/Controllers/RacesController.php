<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Races;

class RacesController extends Controller
{
    public function listRaces(Request $request)
    {

        if ($request->has('nom') && !empty($request->nom)) {
            $races = Races::where('nom', 'like', '%' . $request->nom . '%')->with('sousraces')->get();
            return response()->json($races);
        } else {
            $races = Races::with('sousraces')->orderby('id', 'desc')->get();
            return response()->json($races, 200);
        }
    }

    public function detailsRace(Request $request)
    {
        $race = Races::where("id", "=", $request->id)->with('sousraces')->get();
        return response()->json($race[0], 200);
    }

    public function addRace(Request $request)
    {
        $race = new Races;
        $race->nom = $request->nom;
        $race->description = $request->description;
        $race->icone = $request->icone;
        $idRace = Races::count() + 1;
        $race->id = $idRace;

        $ok = $race->save();
        if ($ok) {
            return response()->json(["status" => 1, "message" => "Race ajouté dans la bd"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "pb lors de
       l'ajout de la race"], 400);
        }
    }

    public function deleteRace(Request $request, $id)
    {
        $race = Races::find($id);
        if ($race) {
            $race->delete();
            return response()->json(["status" => 1, "message" => "Race supprimé de la bd"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "Cette race n'existe pas"], 400);
        }
    }

    public function updateRace(Request $request, $id)
    {
        $race = Races::find($id);
        if ($race) {
            $race->nom = $request->nom;
            $race->description = $request->description;
            $race->icone = $request->icone;
            $race->save();
            return response()->json(["status" => 1, "message" => "race modifié"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "Cette race n'existe pas"], 400);
        }
    }
}

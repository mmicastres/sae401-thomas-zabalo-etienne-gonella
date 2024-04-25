<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Races;

class RacesController extends Controller
{
    public function listRaces(Request $request)
    {

        if ($request->has('nom') && !empty($request->nom)) {
            $races = Races::where('nom', 'like', '%' . $request->nom . '%')->orderby('id')->with('sousraces')->get();
            return response()->json($races);
        } else {
            $races = Races::with('sousraces')->orderby('id')->get();
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
        $idRace = Races::count() + 1;
        $race->id = $idRace;

        // code partagé par Clément, pas mal adapté pour ma situation par ce qu'en fait c'est différent

        $file = $request->file('image');
        $origin = pathinfo($file->getClientOriginalName(), PATHINFO_BASENAME);
        $chemin = '/icone/Race/';
        $heberg = public_path($chemin);
        $file->move($heberg, $origin);
        $race->icone = url($chemin . $origin);

        // Fin du code partagé adapté 

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
            if ($request->icone) {
                $race->icone = $request->icone;
            }
            $race->save();
            return response()->json(["status" => 1, "message" => "race modifié"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "Cette race n'existe pas"], 400);
        }
    }
}

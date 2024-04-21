<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personnages;

class PersonnagesController extends Controller
{
    public function listPersonnages(Request $request)
    {


        if ($request->has('nom') && !empty($request->nom)) {
            $personnages = Personnages::where('nom', 'like', '%' . $request->nom . '%')->get();
            return response()->json($personnages);
        } else {
            $personnages = Personnages::with('sousclasses','sousraces','user')->orderby('id', 'desc')->get();
            return response()->json($personnages, 200);
        }
    }

    public function detailsPersonnage(Request $request)
    {
        $personnage = Personnages::where("id","=",$request->id)->with('origines','sousclasses','sousclasses.classes','sousraces','sousraces.races', 'user','competences','sorts')->get();
        return response()->json($personnage[0], 200);
    }

    public function addPersonnage(Request $request)
    {
        $personnage = new Personnages;
        $personnage->sousraces_id = $request->sousraces_id;
        $personnage->origines_id = $request->origines_id;
        $personnage->sousclasses_id = $request->sousclasses_id;
        $personnage->user_id = $request->user_id;
        $personnage->nom = $request->nom;
        $idPersonnage = Personnages::count() + 1;
        $personnage->id = $idPersonnage;

        $ok = $personnage->save();
        if ($ok) {
            return response()->json(["status" => 1, "message" => "Personnage ajouté dans la bd"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "pb lors de
       l'ajout du personnage"], 400);
        }
    }

    public function deletePersonnage(Request $request, $id)
    {
        $personnage = Personnages::find($id);
        if ($personnage) {
            $personnage->delete();
            return response()->json(["status" => 1, "message" => "Personnage supprimé de la bd"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "Le personnage n'existe pas"], 400);
        }
    }

    public function updatePersonnage(Request $request, $id)
    {
        $personnage = Personnages::find($id);
        if ($personnage) {
            $personnage->race_id = $request->race_id;
            $personnage->origine_id = $request->origine_id;
            $personnage->classe_id = $request->classe_id;
            $personnage->nom = $request->nom;
            $personnage->save();
            return response()->json(["status" => 1, "message" => "personnage modifié"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "Ce personnage n'existe pas"], 400);
        }
    }
}

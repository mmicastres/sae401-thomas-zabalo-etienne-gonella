<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Talents;

class TalentsController extends Controller
{
    public function listTalents(Request $request)
    {


        if ($request->has('nom') && !empty($request->nom)) {
            $talents = Talents::where('nom', 'like', '%' . $request->nom . '%')->orderby('id')->get();
            return response()->json($talents);
        } else {
            $talents = Talents::orderby('id')->get();
            return response()->json($talents, 200);
        }
    }

    public function detailsTalent(Request $request)
    {
        $talent = Talents::where("id", "=", $request->id)->get();
        return response()->json($talent[0], 200);
    }

    public function addTalent(Request $request)
    {
        $talent = new Talents;
        $talent->statistiques_id = $request->statistiques_id;
        $talent->nom = $request->nom;
        $talent->description = $request->description;
        $idTalent = Talents::count() + 1;
        $talent->id = $idTalent;

        // code partagé par Clément, pas mal adapté pour ma situation par ce qu'en fait c'est différent

        $file = $request->file('image');
        $origin = pathinfo($file->getClientOriginalName(), PATHINFO_BASENAME);
        $chemin = '/icone/Talent/';
        $heberg = public_path($chemin);
        $file->move($heberg, $origin);
        $talent->icone = url($chemin . $origin);

        // Fin du code partagé adapté 

        $ok = $talent->save();

        if ($request->classes) {
            $classesIds = $request->classes;
            $talent->classes()->attach($classesIds);
        }

        if ($request->races) {
            $racesIds = $request->races;
            $talent->races()->attach($racesIds);
        }

        if ($request->origines) {
            $originesIds = $request->origines;
            $talent->origines()->attach($originesIds);
        }
        if ($ok) {
            return response()->json(["status" => 1, "message" => "Talent ajouté dans la bd"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "pb lors de
       l'ajout de l'talent"], 400);
        }
    }

    public function deleteTalent(Request $request, $id)
    {
        $talent = Talents::find($id);
        if ($talent) {
            $talent->delete();
            return response()->json(["status" => 1, "message" => "Talent supprimé de la bd"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "Cette talent n'existe pas"], 400);
        }
    }

    public function updateTalent(Request $request, $id)
    {
        $talent = Talents::find($id);
        if ($talent) {
            $talent->statistiques_id = $request->statistiques_id;
            $talent->nom = $request->nom;
            $talent->description = $request->description;
            if ($request->icone) {
                $talent->icone = $request->icone;
            }
            $talent->save();


            if ($request->classes) {
                $classesIds = $request->competences;
                $talent->classes()->attach($classesIds);
            }

            if ($request->races) {
                $racesIds = $request->sorts;
                $talent->races()->attach($racesIds);
            }

            if ($request->origines) {
                $originesIds = $request->talents;
                $talent->origines()->attach($originesIds);
            }
            return response()->json(["status" => 1, "message" => "talent modifié"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "Cette talent n'existe pas"], 400);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Statistiques;

class StatistiquesController extends Controller
{
    public function listStatistiques(Request $request)
    {


        if ($request->has('nom') && !empty($request->nom)) {
            $statistiques = Statistiques::where('nom', 'like', '%' . $request->nom . '%')->orderby('id')->get();
            return response()->json($statistiques);
        } else {
            $statistiques = Statistiques::orderby('id')->get();
            return response()->json($statistiques, 200);
        }
    }

    public function detailsStatistique(Request $request)
    {
        $statistique = Statistiques::where("id", "=", $request->id)->get();
        return response()->json($statistique[0], 200);
    }

    public function addStatistique(Request $request)
    {
        $statistique = new Statistiques;
        $statistique->nom = $request->nom;
        $statistique->description = $request->description;
        $idStatistique = Statistiques::count() + 1;
        $statistique->id = $idStatistique;

        // code partagé par Clément, pas mal adapté pour ma situation par ce qu'en fait c'est différent

        $file = $request->file('image');
        $origin = pathinfo($file->getClientOriginalName(), PATHINFO_BASENAME);
        $chemin = '/icone/Statistique/';
        $heberg = public_path($chemin);
        $file->move($heberg, $origin);
        $statistique->icone = url($chemin . $origin);

        // Fin du code partagé adapté 

        $ok = $statistique->save();
        if ($ok) {
            return response()->json(["status" => 1, "message" => "Statistique ajouté dans la bd"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "pb lors de
       l'ajout de l'statistique"], 400);
        }
    }

    public function deleteStatistique(Request $request, $id)
    {
        $statistique = Statistiques::find($id);
        if ($statistique) {
            $statistique->delete();
            return response()->json(["status" => 1, "message" => "Statistique supprimé de la bd"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "Cette statistique n'existe pas"], 400);
        }
    }

    public function updateStatistique(Request $request, $id)
    {
        $statistique = Statistiques::find($id);
        if ($statistique) {
            $statistique->nom = $request->nom;
            $statistique->description = $request->description;
            $statistique->icone = $request->icone;
            $statistique->save();
            return response()->json(["status" => 1, "message" => "statistique modifié"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "Cette statistique n'existe pas"], 400);
        }
    }
}

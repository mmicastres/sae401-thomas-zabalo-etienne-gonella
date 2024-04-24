<?php

namespace App\Http\Controllers;

use App\Models\SousClasses;
use Illuminate\Http\Request;

class SousclassesController extends Controller
{
    public function listSousclasses(Request $request)
    {

        if ($request->has('nom') && !empty($request->nom)) {
            $sousclasses = Sousclasses::where('nom', 'like', '%' . $request->nom . '%')->orderby('id')->with('classes')->get();
            return response()->json($sousclasses);
        } else {
            $sousclasses = Sousclasses::with('classes')->orderby('id')->get();
            return response()->json($sousclasses, 200);
        }
    }

    public function detailsSousClasse(Request $request)
    {
        $sousclasse = Sousclasses::where("id", "=", $request->id)->with('classes', 'competences', 'sorts')->get();
        return response()->json($sousclasse[0], 200);
    }

    public function addSousClasse(Request $request)
    {
        $sousclasse = new Sousclasses;
        $sousclasse->classes_id = $request->classes_id;
        $sousclasse->nom = $request->nom;
        $sousclasse->description = $request->description;
        $idSousClasse = Sousclasses::count() + 1;
        $sousclasse->id = $idSousClasse;

        // code partagé par Clément, adapté pour ma situation

        $file = $request->file('image');
        $origin = pathinfo($file->getClientOriginalName(), PATHINFO_BASENAME);
        $chemin = '/icone/SousClasse/';
        $heberg = public_path($chemin);
        $file->move($heberg, $origin);
        $sousclasse->icone = url($chemin . $origin);


        // Fin du code partagé adapté 
        $ok = $sousclasse->save();
        if ($ok) {
            return response()->json(["status" => 1, "message" => "Sous classe ajouté dans la bd"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "pb lors de
       l'ajout de la sousclasse"], 400);
        }
    }

    public function deleteSousClasse(Request $request, $id)
    {
        $sousclasse = Sousclasses::find($id);
        if ($sousclasse) {
            $sousclasse->delete();
            return response()->json(["status" => 1, "message" => "Sous classe supprimée de la bd"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "Cette sous classe n'existe pas"], 400);
        }
    }

    public function updateSousClasse(Request $request, $id)
    {
        $sousclasse = Sousclasses::find($id);
        if ($sousclasse) {
            $sousclasse->nom = $request->nom;
            $sousclasse->description = $request->description;
            $sousclasse->icone = $request->icone;
            $sousclasse->save();
            return response()->json(["status" => 1, "message" => "sous classe modifiée"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "Cette Sous classe n'existe pas"], 400);
        }
    }
}

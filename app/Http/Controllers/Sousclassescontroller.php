<?php

namespace App\Http\Controllers;

use App\Models\Sousclasses;
use Illuminate\Http\Request;

class SousclassesController extends Controller
{
    public function listSousclasses(Request $request)
    {

        if ($request->has('nom') && !empty($request->nom)) {
            $sousclasses = Sousclasses::where('nom', 'like', '%' . $request->nom . '%')->get();
            return response()->json($sousclasses);
        } else {
            $sousclasses = Sousclasses::with('classes')->orderby('id', 'desc')->get();
            return response()->json($sousclasses, 200);
        }
    }

    public function detailsSousClasse(Request $request)
    {
        $sousclasse = Sousclasses::where("id", "=", $request->id)->get();
        return response()->json($sousclasse, 200);
    }

    public function addSousClasse(Request $request)
    {
        $sousclasse = new Sousclasses;
        $sousclasse->classes_id = $request->classes_id;
        $sousclasse->nom = $request->nom;
        $sousclasse->description = $request->description;
        $sousclasse->icone = $request->icone;
        $idSousClasse = Sousclasses::count() + 1;
        $sousclasse->id = $idSousClasse;

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

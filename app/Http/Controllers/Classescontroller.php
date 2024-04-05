<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;

class ClassesController extends Controller
{
    public function listClasses(Request $request)
    {

        if ($request->has('nom') && !empty($request->nom)) {
            $classes = Classes::where('nom', 'like', '%' . $request->nom . '%')->with('sousclasses')->get();
            return response()->json($classes);
        } else {
            $classes = Classes::with('sousclasses')->orderby('id', 'desc')->get();
            return response()->json($classes, 200);
        }
    }

    public function detailsClasse(Request $request)
    {
        $classe = Classes::where("id", "=", $request->id)->with('sousclasses')->get();
        return response()->json($classe[0], 200);
    }

    public function addClasse(Request $request)
    {
        $classe = new Classes;
        $classe->nom = $request->nom;
        $classe->description = $request->description;
        $classe->icone = $request->icone;
        $idClasse = Classes::count() + 1;
        $classe->id = $idClasse;

        $ok = $classe->save();
        if ($ok) {
            return response()->json(["status" => 1, "message" => "Classe ajouté dans la bd"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "pb lors de
       l'ajout de l'classe"], 400);
        }
    }

    public function deleteClasse(Request $request, $id)
    {
        $classe = Classes::find($id);
        if ($classe) {
            $classe->delete();
            return response()->json(["status" => 1, "message" => "Classe supprimé de la bd"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "Cette classe n'existe pas"], 400);
        }
    }

    public function updateClasse(Request $request, $id)
    {
        $classe = Classes::find($id);
        if ($classe) {
            $classe->nom = $request->nom;
            $classe->description = $request->description;
            $classe->icone = $request->icone;
            $classe->save();
            return response()->json(["status" => 1, "message" => "classe modifié"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "Cette classe n'existe pas"], 400);
        }
    }
}

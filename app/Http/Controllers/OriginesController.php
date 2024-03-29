<?php

namespace App\Http\Controllers;

use App\Models\Origines;
use Illuminate\Http\Request;


class OriginesController extends Controller
{
    public function listOrigines(Request $request)
    {


        if ($request->has('nom') && !empty($request->nom)) {
            $origines = Origines::where('nom', 'like', '%' . $request->nom . '%')->get();
            return response()->json($origines);
        } else {
            $origines = Origines::orderby('id', 'desc')->get();
            return response()->json($origines, 200);
        }
    }

    public function detailsOrigine(Request $request)
    {
        $origine = Origines::where("id", "=", $request->id)->get();
        return response()->json($origine, 200);
    }

    public function addOrigine(Request $request)
    {
        $origine = new Origines;
        $origine->nom = $request->nom;
        $origine->description = $request->description;
        $origine->icone = $request->icone;
        $idOrigine = Origines::count() + 1;
        $origine->id = $idOrigine;

        $ok = $origine->save();
        if ($ok) {
            return response()->json(["status" => 1, "message" => "Origine ajouté dans la bd"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "pb lors de
       l'ajout de l'origine"], 400);
        }
    }

    public function deleteOrigine(Request $request, $id)
    {
        $origine = Origines::find($id);
        if ($origine) {
            $origine->delete();
            return response()->json(["status" => 1, "message" => "Origine supprimé de la bd"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "Cette origine n'existe pas"], 400);
        }
    }

    public function updateOrigine(Request $request, $id)
    {
        $origine = Origines::find($id);
        if ($origine) {
            $origine->nom = $request->nom;
            $origine->description = $request->description;
            $origine->icone = $request->icone;
            $origine->save();
            return response()->json(["status" => 1, "message" => "origine modifié"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "Cette origine n'existe pas"], 400);
        }
    }
}

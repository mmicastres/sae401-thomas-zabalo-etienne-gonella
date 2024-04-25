<?php

namespace App\Http\Controllers;

use App\Models\Origines;
use Illuminate\Http\Request;


class OriginesController extends Controller
{
    public function listOrigines(Request $request)
    {


        if ($request->has('nom') && !empty($request->nom)) {
            $origines = Origines::where('nom', 'like', '%' . $request->nom . '%')->orderby('id')->get();
            return response()->json($origines);
        } else {
            $origines = Origines::orderby('id')->get();
            return response()->json($origines, 200);
        }
    }

    public function detailsOrigine(Request $request)
    {
        $origine = Origines::where("id", "=", $request->id)->get();
        return response()->json($origine[0], 200);
    }

    public function addOrigine(Request $request)
    {
        $origine = new Origines;
        $origine->nom = $request->nom;
        $origine->description = $request->description;
        $idOrigine = Origines::count() + 1;
        $origine->id = $idOrigine;

        // code partagé par Clément, pas mal adapté pour ma situation par ce qu'en fait c'est différent

        $file = $request->file('image');
        $origin = pathinfo($file->getClientOriginalName(), PATHINFO_BASENAME);
        $chemin = '/icone/Origine/';
        $heberg = public_path($chemin);
        $file->move($heberg, $origin);
        $origine->icone = url($chemin . $origin);

        // Fin du code partagé adapté 

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
            if ($request->icone) {
                $origine->icone = $request->icone;
            }
            $origine->save();
            return response()->json(["status" => 1, "message" => "origine modifié"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "Cette origine n'existe pas"], 400);
        }
    }
}

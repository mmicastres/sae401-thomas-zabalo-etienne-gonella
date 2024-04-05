<?php

namespace App\Http\Controllers;

use App\Models\Sousraces;
use Illuminate\Http\Request;

class SousracesController extends Controller
{
    public function listSousraces(Request $request)
    {

        if ($request->has('nom') && !empty($request->nom)) {
            $sousraces = Sousraces::where('nom', 'like', '%' . $request->nom . '%')->with('races')->get();
            return response()->json($sousraces);
        } else {
            $sousraces = Sousraces::with('races')->orderby('id', 'desc')->get();
            return response()->json($sousraces, 200);
        }
    }

    public function detailsSousRace(Request $request)
    {
        $sousrace = Sousraces::where("id", "=", $request->id)->with('races')->get();
        return response()->json($sousrace[0], 200);
    }

    public function addSousRace(Request $request)
    {
        $sousrace = new Sousraces;
        $sousrace->races_id = $request->races_id;
        $sousrace->nom = $request->nom;
        $sousrace->description = $request->description;
        $sousrace->icone = $request->icone;
        $idSousRace = Sousraces::count() + 1;
        $sousrace->id = $idSousRace;

        $ok = $sousrace->save();
        if ($ok) {
            return response()->json(["status" => 1, "message" => "Sous classe ajouté dans la bd"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "pb lors de
       l'ajout de la sousrace"], 400);
        }
    }

    public function deleteSousRace(Request $request, $id)
    {
        $sousrace = Sousraces::find($id);
        if ($sousrace) {
            $sousrace->delete();
            return response()->json(["status" => 1, "message" => "Sous classe supprimée de la bd"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "Cette sous classe n'existe pas"], 400);
        }
    }

    public function updateSousRace(Request $request, $id)
    {
        $sousrace = Sousraces::find($id);
        if ($sousrace) {
            $sousrace->nom = $request->nom;
            $sousrace->description = $request->description;
            $sousrace->icone = $request->icone;
            $sousrace->save();
            return response()->json(["status" => 1, "message" => "sous classe modifiée"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "Cette Sous classe n'existe pas"], 400);
        }
    }
}

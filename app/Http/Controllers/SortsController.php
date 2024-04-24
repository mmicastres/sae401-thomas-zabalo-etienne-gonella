<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sorts;

class SortsController extends Controller
{
    public function listSorts(Request $request)
    {


        if ($request->has('nom') && !empty($request->nom)) {
            $sorts = Sorts::where('nom', 'like', '%' . $request->nom . '%')->orderby('id')->get();
            return response()->json($sorts);
        } else {
            $sorts = Sorts::orderby('id')->get();
            return response()->json($sorts, 200);
        }
    }

    public function detailsSort(Request $request)
    {
        $sort = Sorts::where("id", "=", $request->id)->get();
        return response()->json($sort[0], 200);
    }

    public function addSort(Request $request)
    {
        $sort = new Sorts;
        $sort->nom = $request->nom;
        $sort->niveau = $request->niveau;
        $sort->description = $request->description;
        $sort->icone = $request->icone;
        $sort->action = $request->action;
        $idSort = Sorts::count() + 1;
        $sort->id = $idSort;
        $ok = $sort->save();

        if ($request->sousRaces) {
            $sousRaces = $request->sousRaces;
            foreach ($sousRaces as $sousRace) {
                $sousRaceId = $sousRace['id'];
                $nivmin = $sousRace['nivmin'];

                $sort->sousRaces()->attach($sousRaceId, ['nivmin' => $nivmin]);
            }
        }
        if ($request->sousClasses) {
            $sousClasses = $request->sousClasses;
            foreach ($sousClasses as $sousClasse) {
                $sousClasseId = $sousClasse['id'];
                $nivmin = $sousClasse['nivmin'];

                $sort->sousClasses()->attach($sousClasseId, ['nivmin' => $nivmin]);
            }
        }

        if ($ok) {
            return response()->json(["status" => 1, "message" => "Sort ajouté dans la bd"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "pb lors de
       l'ajout de l'sort"], 400);
        }
    }

    public function deleteSort(Request $request, $id)
    {
        $sort = Sorts::find($id);
        if ($sort) {
            $sort->delete();
            return response()->json(["status" => 1, "message" => "Sort supprimé de la bd"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "Cette sort n'existe pas"], 400);
        }
    }

    public function updateSort(Request $request, $id)
    {
        $sort = Sorts::find($id);
        if ($sort) {
            $sort->nom = $request->nom;
            $sort->niveau = $request->niveau;
            $sort->description = $request->description;
            $sort->icone = $request->icone;
            $sort->action = $request->action;
            $sort->save();

            if ($request->sousRaces) {
                $sousRaces = $request->sousRaces;
                foreach ($sousRaces as $sousRace) {
                    $sousRaceId = $sousRace['id'];
                    $nivmin = $sousRace['nivmin'];

                    $sort->sousRaces()->sync($sousRaceId, ['nivmin' => $nivmin]);
                }
            }
            if ($request->sousClasses) {
                $sousClasses = $request->sousClasses;
                foreach ($sousClasses as $sousClasse) {
                    $sousClasseId = $sousClasse['id'];
                    $nivmin = $sousClasse['nivmin'];

                    $sort->sousClasses()->sync($sousClasseId, ['nivmin' => $nivmin]);
                }
            }
            return response()->json(["status" => 1, "message" => "sort modifié"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "Cette sort n'existe pas"], 400);
        }
    }
}

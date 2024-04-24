<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Competences;

class CompetencesController extends Controller
{
    public function listCompetences(Request $request)
    {
        if ($request->has('nom') && !empty($request->nom)) {
            $competences = Competences::where('nom', 'like', '%' . $request->nom . '%')->orderby('id')->get();
            return response()->json($competences);
        } else {
            $competences = Competences::orderby('id')->get();
            return response()->json($competences, 200);
        }
    }

    public function detailsCompetence(Request $request)
    {
        $competence = Competences::where("id", "=", $request->id)->get();
        return response()->json($competence[0], 200);
    }

    public function addCompetence(Request $request)
    {
        $competence = new Competences;
        $competence->nom = $request->nom;
        $competence->description = $request->description;
        $competence->action = $request->action;
        $idCompetence = Competences::count() + 1;
        $competence->id = $idCompetence;

        // code partagé par Clément, pas mal adapté pour ma situation par ce qu'en fait c'est différent

        $file = $request->file('image');
        $origin = pathinfo($file->getClientOriginalName(), PATHINFO_BASENAME);
        $chemin = '/icone/Competence/';
        $heberg = public_path($chemin);
        $file->move($heberg, $origin);
        $competence->icone = url($chemin . $origin);

        // Fin du code partagé adapté 
        
        $ok = $competence->save();
        if ($request->sousRaces) {
            $sousRaces = $request->sousRaces;
            foreach ($sousRaces as $sousRace) {
                $sousRaceId = $sousRace['id'];
                $nivmin = $sousRace['nivmin'];
                $competence->sousRaces()->attach($sousRaceId, ['nivmin' => $nivmin]);
            }
        }
        if ($request->sousClasses) {
            $sousClasses = $request->sousClasses;
            foreach ($sousClasses as $sousClasse) {
                $sousClasseId = $sousClasse['id'];
                $nivmin = $sousClasse['nivmin'];

                $competence->sousClasses()->attach($sousClasseId, ['nivmin' => $nivmin]);
            }
        }
        if ($ok) {
            return response()->json(["status" => 1, "message" => "Competence ajouté dans la bd"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "pb lors de
       l'ajout de l'competence"], 400);
        }
    }

    public function deleteCompetence(Request $request, $id)
    {
        $competence = Competences::find($id);
        if ($competence) {
            $competence->delete();
            return response()->json(["status" => 1, "message" => "Competence supprimé de la bd"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "Cette competence n'existe pas"], 400);
        }
    }

    public function updateCompetence(Request $request, $id)
    {
        $competence = Competences::find($id);
        if ($competence) {
            $competence->nom = $request->nom;
            $competence->description = $request->description;
            $competence->icone = $request->icone;
            $competence->action = $request->action;
            $competence->save();
            if ($request->sousRaces) {
                $sousRaces = $request->sousRaces;
                foreach ($sousRaces as $sousRace) {
                    $sousRaceId = $sousRace['id'];
                    $nivmin = $sousRace['nivmin'];

                    $competence->sousRaces()->sync($sousRaceId, ['nivmin' => $nivmin]);
                }
            }
            if ($request->sousClasses) {
                $sousClasses = $request->sousClasses;
                foreach ($sousClasses as $sousClasse) {
                    $sousClasseId = $sousClasse['id'];
                    $nivmin = $sousClasse['nivmin'];

                    $competence->sousClasses()->sync($sousClasseId, ['nivmin' => $nivmin]);
                }
            }
            return response()->json(["status" => 1, "message" => "competence modifié"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "Cette competence n'existe pas"], 400);
        }
    }
}

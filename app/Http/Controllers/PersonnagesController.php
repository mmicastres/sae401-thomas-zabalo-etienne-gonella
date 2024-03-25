    <?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Personnages;

    class PersonnagesController extends Controller
    {
        public function listPersonnages(Request $request)
        {
            $personnages = Personnages::orderby('id','desc')->get();
            return response()->json([$personnages], 200);
        }

        public function detailsPersonnage(Request $request)
        {
            $personnage = Personnages::find($request->id);
            return response()->json([$personnage], 200);
        }

        public function addPersonnage(Request $request)
        {
            $personnage = new Personnages;
            $personnage->race_id = $request->race_id;
            $personnage->origine_id = $request->origine_id;
            $personnage->classe_id = $request->classe_id;
            $personnage->utilisateur_id = $request->utilisateur_id;
            $personnage->nom = $request->nom;
            $idPersonnage = Personnages::count()+1;
            $personnage->id = $idPersonnage;

            $ok = $personnage->save();
            if ($ok) {
                return response()->json(["status" => 1, "message" => "Personnage ajouté dans la bd"], 201);
            } else {
                return response()->json(["status" => 0, "message" => "pb lors de
        l'ajout"], 400);
            }
        }
    }
        
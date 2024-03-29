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
}

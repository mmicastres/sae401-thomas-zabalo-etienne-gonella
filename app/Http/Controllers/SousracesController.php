<?php

namespace App\Http\Controllers;

use App\Models\Sousraces;
use Illuminate\Http\Request;

class SousracesController extends Controller
{
    public function listSousraces(Request $request)
    {

        if ($request->has('nom') && !empty($request->nom)) {
            $sousraces = Sousraces::where('nom', 'like', '%' . $request->nom . '%')->get();
            return response()->json($sousraces);
        } else {
            $sousraces = Sousraces::with('races')->orderby('id', 'desc')->get();
            return response()->json($sousraces, 200);
        }
    }

    public function detailsSousRace(Request $request)
    {
        $sousrace = Sousraces::where("id", "=", $request->id)->get();
        return response()->json($sousrace, 200);
    }
}

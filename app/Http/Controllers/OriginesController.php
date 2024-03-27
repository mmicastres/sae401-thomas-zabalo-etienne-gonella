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
        }
        else {
            $personnages = Origines::with('personnageso')->orderby('id', 'desc')->get();
            return response()->json($personnages, 200);
        }
    }
}

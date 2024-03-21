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
}

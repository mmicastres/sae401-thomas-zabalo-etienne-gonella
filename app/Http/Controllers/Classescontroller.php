<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;

class ClassesController extends Controller
{
    public function listClasses(Request $request)
    {

        if ($request->has('nom') && !empty($request->nom)) {
            $classes = Classes::where('nom', 'like', '%' . $request->nom . '%')->get();
            return response()->json($classes);
        } else {
            $classes = Classes::with('sousclasses')->orderby('id', 'desc')->get();
            return response()->json($classes, 200);
        }
    }

    public function detailsClasse(Request $request)
    {
        $classe = Classes::where("id", "=", $request->id)->get();
        return response()->json($classe, 200);
    }
}

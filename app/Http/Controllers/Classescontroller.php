<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;

class Classescontroller extends Controller
{
    public function listClasses(Request $request)
    {


        if ($request->has('nom') && !empty($request->nom)) {
            $classes = Classes::where('nom', 'like', '%' . $request->nom . '%')->get();
            return response()->json($classes);
        } else {
            $classes = Classes::with('Sous_classes')->orderby('id', 'desc')->get();
            return response()->json($classes, 200);
        }
    }
}

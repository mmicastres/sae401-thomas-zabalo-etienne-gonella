<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function listUsers(Request $request)
    {

        if ($request->has('nom') && !empty($request->nom)) {
            $users = User::where('nom', 'like', '%' . $request->nom . '%')->get();
            return response()->json($users);
        } else {
            $users = User::with('classes')->orderby('id', 'desc')->get();
            return response()->json($users, 200);
        }
    }

    public function detailsUser(Request $request)
    {
        $user = User::where("id", "=", $request->id)->get();
        return response()->json($user, 200);
    }

    public function addUser(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $idUser = User::count() + 1;
        $user->id = $idUser;

        $ok = $user->save();
        if ($ok) {
            return response()->json(["status" => 1, "message" => "User ajouté dans la bd"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "pb lors de
       l'ajout de la user"], 400);
        }
    }

    public function deleteUser(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return response()->json(["status" => 1, "message" => "User supprimé de la bd"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "Cette user n'existe pas"], 400);
        }
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->save();
            return response()->json(["status" => 1, "message" => "user modifié"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "Cette User n'existe pas"], 400);
        }
    }
}

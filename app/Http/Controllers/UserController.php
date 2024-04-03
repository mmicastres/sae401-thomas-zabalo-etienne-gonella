<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller

{

    public function test(Request $request)
    {
        $user = $request->user();
        if ($user->tokenCan('dodrugs')) {
            return ("tu peux le faire");
        }
        return ("tu ne peux pas le faire");
    }
    // Gestion des Token
    public function login(LoginRequest $request)
    {
        // -- LoginRequest a verifié que les email et password étaient présents
        // -- il faut maintenant vérifier que les identifiants sont corrects
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status' => 0,
                'message' => 'Utilisateur inexistant ou identifiants incorreccts'
            ], 401);
        }
        // tout est ok, on peut générer le token
        $user = $request->user();
        if ($user->tokens()) {
            $user->tokens()->delete();
        } else {
        }
        if ($user->administrateur) {
            $tokenResult = $user->createToken('Personal Access Token', ['abilities:administrateur']);
            $token = $tokenResult->plainTextToken;
            return response()->json([
                'status' => 1,
                'accessToken' => $token,
                'token_type' => 'Bearer',
                'user_id' => $user->id,
                'admin' => 'admin'
            ]);
        } else {
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->plainTextToken;
            return response()->json([
                'status' => 1,
                'accessToken' => $token,
                'token_type' => 'Bearer',
                'user_id' => $user->id
            ]);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        // Revoke the token that was used to authenticate the current request...
        $ok = $user->tokens()->delete();
        if ($ok) {
            return response()->json([
                'message' => 'token deleted, logged out',
                'user_id' => $user->id
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'Pas de tokens existants'
            ], 401);
        }
    }

    public function listUsers(Request $request)
    {

        if ($request->has('nom') && !empty($request->nom)) {
            $users = User::where('name', 'like', '%' . $request->nom . '%')->get();
            return response()->json($users);
        } else if ($request->has('email') && !empty($request->email)) {
            $users = User::where('email', 'like', '%' . $request->email . '%')->get();
            return response()->json($users);
        } else {
            $users = User::orderby('id', 'desc')->get();
            return response()->json($users, 200);
        }
    }

    public function detailsUser(Request $request)
    {
        $user = User::where("id", "=", $request->id)->with('personnages', 'personnages.sousraces', 'personnages.sousclasses')->get();
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

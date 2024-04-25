<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller

{
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
            $tokenResult = $user->createToken('Personal Access Token', ['administrateur']);
            $token = $tokenResult->plainTextToken;
            return response()->json([
                'status' => 1,
                'accessToken' => $token,
                'token_type' => 'Bearer',
                'user_id' => $user->id,
                'admin' => 'admin'
            ]);
        } else {
            $tokenResult = $user->createToken('Personal Access Token', ['utilisateur']);
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
        $user = $request->user();
        if ($user->administrateur || $user->id == $request->id) {
            $detailUser = User::where("id", "=", $request->id)->with('personnages', 'personnages.sousraces', 'personnages.sousclasses')->get();
            return response()->json($detailUser[0], 200);
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'Pas le bon votre id, pas admin'
            ], 401);
        }
    }

    public function addUser(Request $request)
    {
        $verif = User::where("email", "=", $request->email)->get();
        if ($verif->isNotEmpty()) {
            return response()->json(["status" => 0, "message" => "email déjà utilisé"], 400);
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $idUser = User::count() + 1;
        $user->id = $idUser;

        // code partagé par Clément, pas mal adapté pour ma situation par ce qu'en fait c'est différent

        $file = $request->file('image');
        $origin = pathinfo($file->getClientOriginalName(), PATHINFO_BASENAME);
        $chemin = '/icone/User/';
        $heberg = public_path($chemin);
        $file->move($heberg, $origin);
        $user->icone = url($chemin . $origin);

        // Fin du code partagé adapté 

        $ok = $user->save();
        if ($ok) {
            return response()->json(["status" => 1, "message" => "User ajouté dans la bd"], 201);
        } else {
            return response()->json(["status"  => 0, "message" => "pb lors de
       l'ajout de la user"], 400);
        }
    }

    public function deleteUser(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $chemin = '/home/zabalo/www/sae401/public/icone/User/';
            $icone = basename($user->icone);
            $relatif = $chemin . $icone;

            if (file_exists($relatif)) {
                unlink($relatif);
            }

            $user->tokens()->delete();
            $user->delete();
            return response()->json(["status" => 1, "message" => "User supprimé de la bd"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "Cette user n'existe pas"], 400);
        }
    }

    public function updateUser(Request $request, $id)
    {

        $user = $request->user();
        if ($user->administrateur || $user->id == $request->id) {
            $modifUser = User::find($id);

            if ($modifUser) {
                $modifUser->name = $request->name;
                $modifUser->email = $request->email;
                $modifUser->password = $request->password;

                $ok = $modifUser->save();
                if ($ok) {
                    return response()->json(["status" => 1, "message" => "user modifié"], 201);
                } else {
                    return response()->json(["status" => 0, "message" => "problème lors de la modif"], 400);
                }
            } else {
                return response()->json(["status" => 0, "message" => "Ce user n'existe pas"], 400);
            }
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'Pas le bon votre id, pas admin'
            ], 401);
        }
    }

    public function updateIconeUser(Request $request, $id)
    {
        $user = User::find($id);
        $chemin = '/home/zabalo/www/sae401/public/icone/User/';
        $icone = basename($user->icone);
        $relatif = $chemin . $icone;

        if (file_exists($relatif)) {
            unlink($relatif);
        }

        // code partagé par Clément, pas mal adapté pour ma situation par ce qu'en fait c'est différent

        $file = $request->file('image');
        $origin = pathinfo($file->getClientOriginalName(), PATHINFO_BASENAME);
        $heberg = public_path('/icone/User/');
        $file->move($heberg, $origin);
        $user->icone = url($chemin . $origin);
        $ok = $user->save();
        if ($ok) {
            return response()->json(["status" => 1, "message" => "icone modifié"], 201);
        } else {
            return response()->json(["status" => 0, "message" => "problème lors de la modif"], 400);
        }
        // Fin du code partagé adapté 
    }
}

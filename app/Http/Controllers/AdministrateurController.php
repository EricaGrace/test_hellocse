<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Administrateur;
use App\Http\Requests\StoreAdminRequest;
use Illuminate\Support\Facades\Hash;

class AdministrateurController extends Controller
{
    public function index() // fonction servant à récupérer la liste des admins sans conditions
    {
        $admin = Administrateur::all();
        return response()->json($admin);
    }

    public function inscription(StoreAdminRequest $request) # fonction servant à inscrire un nouvel admin , présence d'une formrequest
    {

        $admin = Administrateur::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'mot_de_passe' => Hash::make($request->mot_de_passe),
        ]);

       // dd($admin);

        $token = $admin->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'message'   => 'Utilisateur créé !'
        ]);
    }

    public function connexion(Request $request) // fonction servant à la connexion des admins 
    {
        $request->validate([  // vérification/ validation des données requises 
            'email' => ['required', 'string', 'email', 'max:255'],
            'mot_de_passe' => ['required', 'string'],
        ]);

        $admin = Administrateur::where('email', $request->email)->first(); // recherche de l'admin dont l'email rentré correspond

        if (!$admin || !Hash::check($request->mot_de_passe, $admin->mot_de_passe)) { // si le mot de passe ne correspond pas, envoyer un message d'erreur
            return response()->json(['message' => 'Identifiant ou mot de passe invalide'], 401);
        }

        $token = $admin->createToken('auth_token')->plainTextToken; // création d'un token d'accès

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function deconnexion(Request $request)
    {
    if ($request->user() && $request->user()->currentAccessToken()) {
        $request->user()->currentAccessToken()->delete();
    }
    return response()->json(['message' => 'Déconnecté']);
    }

}

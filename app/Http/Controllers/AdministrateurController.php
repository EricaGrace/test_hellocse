<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Administrateur;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdministrateurController extends Controller
{
    public function index(){
        $admin = Administrateur::All();
        return response()->json($admin);
    }

    public function inscription(Request $request)
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:administrateurs,email'],
            'mot_de_passe' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $admin = Administrateur::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'mot_de_passe' => Hash::make($request->mot_de_passe),
        ]);

        $token = $admin->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function connexion(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'mot_de_passe' => ['required', 'string'],
        ]);

        $admin = Administrateur::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->mot_de_passe, $admin->mot_de_passe)) {
            return response()->json(['message' => 'Identifiant ou mot de passe invalide'], 401);
        }

        $token = $admin->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function deconnexion(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Déconnecté']);
    }
}

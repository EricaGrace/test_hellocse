<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Http\Requests\StoreProfileRequest;

class ProfileController extends Controller
{
    public function index() ## la fonction index sert à afficher tous les profils dont le statut est actif !
    {
        $profiles = Profile::where('statut', 'actif')->get(['nom', 'prenom', 'image']);
        return response()->json($profiles);
    }

    public function create_profile(StoreProfileRequest $request) // Sert pour la créeation des profiles. StoreProfileRequest est une Formrequest qui sert à la validation des données 
    {
        $profile = new Profile();
        $profile->nom = $request->nom;
        $profile->prenom = $request->prenom;
        if ($request->hasFile('image')) {
            $profile->image = $request->file('image')->store('images', 'public');
        }
        $profile->statut = $request->statut;
        $profile->save();

        return response()->json(['message' => 'Profile créé!'], 201);
    }

    public function update_profile(StoreProfileRequest $request, $id) ## fonction servant à modifier les données d'un profile
    {
        $profile = Profile::findOrFail($id); # on sélectionne le profile par id 
        $profile->update($request->all());

        if ($request->hasFile('image')) {
            $profile->image = $request->file('image')->store('images', 'public');
        }

        return response()->json(['message' => 'Profile mis à jour!'], 200);
    }

    public function delete_profile($id) ## fonction servant à supprimer un profile par l'id 
    {
        $profile = Profile::findOrFail($id);
        $profile->delete();
        return response()->json(['message' => 'Profile supprimé!'], 200);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Http\Requests\StoreProfileRequest;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index() 
    {
        $profiles = Profile::where('statut', 'actif')->get(['nom', 'prenom', 'image']);
        return response()->json($profiles);
    }

    public function store(StoreProfileRequest $request)
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

    public function update(StoreProfileRequest $request, $id)
    {
        $profile = Profile::findOrFail($id); 
        $profile->update($request->all());

        if ($request->hasFile('image')) {
            Storage::delete('public/' . $profile->image);
            $profile->image = $request->file('image')->store('images', 'public');
        }

        return response()->json(['message' => 'Profile mis à jour!'], 200);
    }

    public function destroy($id) 
    {
        try {
            $profile = Profile::findOrFail($id);
            $profile->delete();
            return response()->json(['message' => 'Profile supprimé!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la suppression du profile'], 500);
        }
    }
}

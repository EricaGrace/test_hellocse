<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreProfileRequest;

class ProfileController extends Controller
{
    public function index(){
        $profiles = Profile::where('statut', 'actif')->get('nom','prenom','image');
        return response()->json($profiles);
    }

    public function create_profile(StoreProfileRequest $request){
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

    public function update_profile(StoreProfileRequest $request, $id){
        $profile = Profile::find($id);
        $profile->update($request->all());
        return response()->json(['message' => 'Profile mis à jour!'], 201);
    }

    public function delete_profile($id){
        $profile = Profile::find($id);
        $profile->delete();
        return response()->json(['message' => 'Profile supprimé!'], 201);
    }
}

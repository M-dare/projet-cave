<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    // / Affiche le formulaire de modification du profil. Accessible via GET /profil
    public function edit()
    {
        // On récupère l'utilisateur connecté OU le premier de la base pour le test
        $user = Auth::user() ?: User::first();

        return view('profile.edit', compact('user'));
    }

    // Enregistre les modifications dans la base de données. Accessible via POST /profil
    public function update(Request $request)
    {
        // On identifie l'utilisateur à modifier
        $user = Auth::user() ?: User::first();

        // Sécurité : Si aucun utilisateur n'existe du tout
        if (!$user) {
            return back()->with('status', 'Erreur : Aucun utilisateur trouvé en base de données.');
        }

        // Validation des données du formulaire
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        // Mise à jour des informations
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // Sauvegarde dans MySQL
        $user->save();

        // Retour à la page avec un message de succès
        return back()->with('status', 'Profil mis à jour avec succès !');
    }
}
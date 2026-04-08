<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
<<<<<<< HEAD
    /**
     * Affiche le formulaire de modification du profil.
     */
=======
    // / Affiche le formulaire de modification du profil. Accessible via GET /profil
>>>>>>> d0042544181037b1bae9946a6a6d183528eadbb5
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

<<<<<<< HEAD
    /**
     * Met à jour le profil et le mot de passe.
     */
=======
    // Enregistre les modifications dans la base de données. Accessible via POST /profil
>>>>>>> d0042544181037b1bae9946a6a6d183528eadbb5
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        return back()->with('status', 'Profil et mot de passe mis à jour !');
    }
}
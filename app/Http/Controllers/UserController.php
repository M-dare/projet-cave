<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * AFFICHER & RECHERCHER : Liste des utilisateurs
     */
    public function index(Request $request)
    {
        // Récupération du mot-clé de recherche depuis le formulaire
        $search = $request->input('search');

        // Construction de la requête avec filtrage si une recherche est lancée
        $users = User::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%{$search}%")
                         ->orWhere('email', 'LIKE', "%{$search}%");
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10); // Pagination pour la performance

        return view('users.index', compact('users', 'search'));
    }

    /**
     * FORMULAIRE D'AJOUT
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * AJOUTER : Enregistrement d'un nouvel utilisateur
     */
    public function store(Request $request)
    {
        // Validation des données entrantes
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,client',
        ]);

        // Création de l'utilisateur avec hachage du mot de passe
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * FORMULAIRE DE MODIFICATION
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * MODIFIER : Mise à jour des informations
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,client',
        ]);

        // Mise à jour des champs
        $user->update($request->only('name', 'email', 'role'));

        // Si un nouveau mot de passe est saisi, on le hache et on l'enregistre
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour.');
    }

    /**
     * SUPPRIMER : Retrait d'un utilisateur
     */
    public function destroy(User $user)
    {
        // Sécurité : Empêcher l'admin connecté de se supprimer lui-même
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Action impossible : vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use App\Models\Boisson;
use App\Models\User;
use Illuminate\Http\Request;

class VenteController extends Controller
{
    public function index()
    {
        $ventes = Vente::with(['boisson', 'user'])->latest()->get();
        return view('ventes.index', compact('ventes'));
    }

    public function create()
    {
        $boissons = Boisson::where('quantite', '>', 0)->get();
        $users = User::all();
        return view('ventes.create', compact('boissons', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'boisson_id' => 'required',
            'user_id' => 'required',
            'quantite' => 'required|integer|min:1',
        ]);

        $boisson = Boisson::findOrFail($request->boisson_id);
        $total = $boisson->prix_unitaire * $request->quantite;

        if ($boisson->quantite < $request->quantite) {
            return back()->with('error', 'Stock insuffisant pour cette boisson.');
        }

        // Création forcée avec tous les champs requis par ta base de données
        $vente = new Vente();
        $vente->boisson_id = $request->boisson_id;
        $vente->user_id = $request->user_id;
        $vente->quantite = $request->quantite;
        $vente->prix_total = $total;
        $vente->montant_recu = $total; // Correction de l'erreur 1364
        $vente->save();

        $boisson->decrement('quantite', $request->quantite);

        return redirect()->route('ventes.index')->with('success', 'Vente enregistrée : ' . $total . ' FCFA');
    }

    public function destroy($id)
    {
        $vente = Vente::findOrFail($id);
        $boisson = Boisson::findOrFail($vente->boisson_id);
        $boisson->increment('quantite', $vente->quantite);
        $vente->delete();
        return redirect()->route('ventes.index')->with('success', 'Vente annulée.');
    }
}
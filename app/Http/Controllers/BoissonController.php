<?php

namespace App\Http\Controllers;

use App\Models\Boisson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoissonController extends Controller
{
    /**
     * Liste des boissons avec Recherche et Statistiques (Stats réservées Admin)
     */
    public function index(Request $request)
    {
        // 1. Nettoyage de la recherche
        $search = trim($request->input('search'));
        $listeTypes = ['eau', 'sucrerie', 'alcool', 'jus', 'bière', 'biere', 'vin', 'liqueur'];

        // 2. Exécution de la requête (Visible par tous)
        $boissons = Boisson::when($search, function ($query, $search) use ($listeTypes) {
            return $query->where(function($q) use ($search, $listeTypes) {
                if (in_array(strtolower($search), $listeTypes)) {
                    $q->where('type', '=', $search);
                } else {
                    $q->where('nom', 'like', "%{$search}%");
                }
            });
        })->get();

        // 3. Initialisation des stats par défaut (vides)
        $stats = [
            'nb_boissons'  => 0,
            'total_stock'  => 0,
            'valeur_cave'  => 0,
            'chart_labels' => [],
            'chart_data'   => [],
        ];

        // 4. Calcul des statistiques UNIQUEMENT si l'utilisateur est admin
        if (auth()->user()->role === 'admin') {
            $repartition = Boisson::select('type', DB::raw('count(*) as total'))
                                  ->groupBy('type')
                                  ->get();

            $stats = [
                'nb_boissons'  => Boisson::count(),
                'total_stock'  => Boisson::sum('quantite'),
                'valeur_cave'  => Boisson::select(DB::raw('SUM(quantite * prix_unitaire) as total'))->first()->total ?? 0,
                'chart_labels' => $repartition->pluck('type'),
                'chart_data'   => $repartition->pluck('total'),
            ];
        }

        // 5. Envoi à la vue
        return view('boissons.index', compact('boissons', 'stats'));
    }

    /**
     * Formulaire de création (Sécurisé Admin)
     */
    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, "Accès refusé : Vous n'êtes pas administrateur.");
        }
        return view('boissons.create');
    }

    /**
     * Enregistrement (Sécurisé Admin)
     */
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'nom'           => 'required|string|max:255',
            'type'          => 'required|string',
            'quantite'      => 'required|integer|min:0',
            'prix_unitaire' => 'required|numeric|min:0',
            'categorie_id'  => 'required',
        ]);

        Boisson::create($request->all());
        return redirect()->route('boissons.index')->with('success', 'Boisson ajoutée avec succès !');
    }

    /**
     * Formulaire d'édition (Sécurisé Admin)
     */
    public function edit($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, "Action non autorisée.");
        }
        $boisson = Boisson::findOrFail($id);
        return view('boissons.edit', compact('boisson'));
    }

    /**
     * Mise à jour (Sécurisé Admin)
     */
    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'nom'           => 'required|string|max:255',
            'type'          => 'required|string',
            'quantite'      => 'required|integer|min:0',
            'prix_unitaire' => 'required|numeric|min:0',
            'categorie_id'  => 'required',
        ]);

        $boisson = Boisson::findOrFail($id);
        $boisson->update($request->all());
        return redirect()->route('boissons.index')->with('success', 'La boisson a été mise à jour !');
    }

    /**
     * Suppression (Sécurisé Admin)
     */
    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
        $boisson = Boisson::findOrFail($id);
        $boisson->delete();
        return redirect()->route('boissons.index')->with('success', 'Boisson retirée de la cave.');
    }
}
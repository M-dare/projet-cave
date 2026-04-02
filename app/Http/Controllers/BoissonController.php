<?php

namespace App\Http\Controllers;

use App\Models\Boisson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoissonController extends Controller
{
    /**
     * Liste des boissons avec Recherche, Statistiques et Graphique
     */
    public function index(Request $request)
    {
        // 1. Nettoyage de la recherche
        $search = trim($request->input('search'));
        
        // Liste des types reconnus pour forcer une recherche stricte
        $listeTypes = ['eau', 'sucrerie', 'alcool', 'jus', 'bière', 'biere', 'vin', 'liqueur'];

        // 2. Exécution de la requête avec filtrage intelligent
        $boissons = Boisson::when($search, function ($query, $search) use ($listeTypes) {
            return $query->where(function($q) use ($search, $listeTypes) {
                // Si le mot tapé est un TYPE connu, on cherche l'égalité exacte
                if (in_array(strtolower($search), $listeTypes)) {
                    $q->where('type', '=', $search);
                } else {
                    // Sinon, on cherche si le NOM contient le mot (ex: Lafi, Beaufort)
                    $q->where('nom', 'like', "%{$search}%");
                }
            });
        })->get();

        // 3. Récupération des données pour le graphique (Répartition par type)
        $repartition = Boisson::select('type', DB::raw('count(*) as total'))
                              ->groupBy('type')
                              ->get();

        // 4. Préparation du tableau de statistiques globales
        $stats = [
            'nb_boissons'    => Boisson::count(),
            'total_stock'    => Boisson::sum('quantite'),
            'valeur_cave'    => Boisson::select(DB::raw('SUM(quantite * prix_unitaire) as total'))->first()->total ?? 0,
            'chart_labels'   => $repartition->pluck('type'),
            'chart_data'     => $repartition->pluck('total'),
        ];

        // 5. Envoi à la vue
        return view('boissons.index', compact('boissons', 'stats'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        return view('boissons.create');
    }

    /**
     * Enregistrement en base de données
     */
    public function store(Request $request)
    {
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
     * Formulaire d'édition
     */
    public function edit($id)
    {
        $boisson = Boisson::findOrFail($id);
        return view('boissons.edit', compact('boisson'));
    }

    /**
     * Mise à jour des données
     */
    public function update(Request $request, $id)
    {
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
     * Suppression d'une boisson
     */
    public function destroy($id)
    {
        $boisson = Boisson::findOrFail($id);
        $boisson->delete();

        return redirect()->route('boissons.index')->with('success', 'Boisson retirée de la cave.');
    }
}
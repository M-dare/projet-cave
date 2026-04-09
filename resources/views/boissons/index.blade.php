@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    {{-- 1. BANNIÈRE LOGISTIQUE --}}
    <div class="card shadow border-0 mb-4 overflow-hidden" style="border-radius: 15px;">
        <div class="position-relative">
            <img src="{{ asset('images/charge.png') }}" alt="Bannière" style="width: 100%; height: 250px; object-fit: cover; filter: brightness(0.6);">
            <div class="card-img-overlay d-flex flex-column justify-content-center text-white px-5">
                <h1 class="fw-bold display-5">CAVE DE BOISSONS - DETAIL & GROS</h1>
                <p class="lead">Gestion des stocks de masse et distribution régionale (Burkina Faso)</p>
            </div>
        </div>
    </div>

    {{-- 2. STATISTIQUES ET GRAPHIQUE --}}
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="row h-100">
                <div class="col-md-4 mb-3">
                    <div class="card bg-primary text-white shadow border-0 p-3 text-center h-100 d-flex flex-column justify-content-center">
                        <small>Références en Stock</small>
                        <h2 class="fw-bold mb-0">{{ $boissons->count() }}</h2>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card bg-success text-white shadow border-0 p-3 text-center h-100 d-flex flex-column justify-content-center">
                        <small>Volume Total (Unités)</small>
                        <h2 class="fw-bold mb-0">{{ number_format($boissons->sum('quantite'), 0, ',', ' ') }}</h2>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card bg-dark text-warning shadow border-0 p-3 text-center h-100 d-flex flex-column justify-content-center">
                        <small>Valeur Inventaire</small>
                        <h2 class="fw-bold text-uppercase mb-0" style="font-size: 1.2rem;">
                            {{ number_format($boissons->sum(function($b){ return $b->quantite * $b->prix_unitaire; }), 0, ',', ' ') }} FCFA
                        </h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow border-0 p-3 text-center h-100">
                <h6 class="fw-bold mb-2">Répartition par Type</h6>
                <div style="height: 150px;">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- NOUVEAU : BARRE DE RECHERCHE AVEC BOUTON RAFRAICHIR --}}
    <div class="card shadow border-0 mb-4">
        <div class="card-body">
            <form action="{{ route('boissons.index') }}" method="GET">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted">🔍</i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0" 
                           placeholder="Rechercher une boisson par nom ou par type..." 
                           value="{{ request('search') }}">
                    
                    <button class="btn btn-dark px-4" type="submit">Filtrer</button>
                    
                    {{-- Le bouton Rafraîchir n'apparaît que si on a fait une recherche --}}
                    @if(request('search'))
                        <a href="{{ route('boissons.index') }}" class="btn btn-outline-secondary" title="Rafraîchir la liste">
                            🔄 Annuler
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- 3. LE TABLEAU DES BOISSONS --}}
    <div class="card shadow border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 fw-bold text-dark">Inventaire détaillé des boissons</h5>
            <a href="{{ route('boissons.create') }}" class="btn btn-primary btn-sm">+ Ajouter une boisson</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Désignation</th>
                            <th>Type</th>
                            <th>Prix Unitaire</th>
                            <th>Stock</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($boissons as $boisson)
                        <tr>
                            <td class="fw-bold text-dark">{{ $boisson->nom }}</td>
                            <td><span class="badge bg-secondary">{{ $boisson->type }}</span></td>
                            <td class="fw-bold text-primary">
                                {{ number_format($boisson->prix_unitaire ?? 0, 0, ',', ' ') }} FCFA
                            </td>
                            <td>
                                @php $stockActuel = $boisson->quantite ?? 0; @endphp
                                @if($stockActuel <= 5)
                                    <span class="badge bg-danger">Alerte ! ({{ $stockActuel }})</span>
                                @else
                                    <span class="badge bg-success">{{ $stockActuel }} unités</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('boissons.edit', $boisson->id) }}" class="btn btn-sm btn-outline-info">Modifier</a>
                                    <form action="{{ route('boissons.destroy', $boisson->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer ?')">X</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i>Aucune boisson ne correspond à votre recherche.</i>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPTS POUR LE GRAPHIQUE --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('categoryChart').getContext('2d');
        
        // On récupère les données envoyées par le Controller
        const dataBoissons = {!! json_encode($boissons) !!};
        
        // 1. Calcul des totaux par type (pour le graphique)
        const counts = {};
        dataBoissons.forEach(b => {
            counts[b.type] = (counts[b.type] || 0) + parseInt(b.quantite);
        });

        // 2. Ta palette triée par ordre alphabétique
        const colorPalette = {
            'Alcool':   '#dc3545', // Rouge
            'Bière':    '#198754', // Vert
            'Eau':      '#0d6efd', // Bleu
            'Energie':  '#343a40', // Noir
            'Jus':      '#6610f2', // Violet
            'Sucrerie': '#ffc107'  // Jaune
        };

        // 3. Récupérer les labels et les couleurs correspondantes
        const labels = Object.keys(counts);
        const dynamicColors = labels.map(label => colorPalette[label] || '#bcbcbc');

        // 4. Génération du graphique
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: Object.values(counts),
                    backgroundColor: dynamicColors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false } // On cache la légende pour garder le design épuré
                }
            }
        });
    });
</script>
@endsection
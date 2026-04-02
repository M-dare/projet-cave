<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma Cave - Groupe 05</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .card-stat { border: none; border-radius: 12px; transition: 0.3s; }
        .card-stat:hover { transform: scale(1.02); }
        #myChart { max-height: 250px; }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('boissons.index') }}">🍷 CAVE DASHBOARD | GROUPE 05</a>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row mb-4">
            <div class="col-md-8">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card card-stat bg-primary text-white shadow h-100">
                            <div class="card-body text-center d-flex flex-column justify-content-center">
                                <small>Produits différents</small>
                                <h2 class="fw-bold">{{ $stats['nb_boissons'] }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-stat bg-success text-white shadow h-100">
                            <div class="card-body text-center d-flex flex-column justify-content-center">
                                <small>Total Bouteilles</small>
                                <h2 class="fw-bold">{{ $stats['total_stock'] }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card card-stat bg-dark text-warning shadow">
                            <div class="card-body text-center">
                                <small>Valeur Totale du Stock</small>
                                <h2 class="fw-bold">{{ number_format($stats['valeur_cave'], 0, ',', ' ') }} FCFA</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <h6 class="text-muted mb-3">Répartition par Type</h6>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <form action="{{ route('boissons.index') }}" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" 
                                   placeholder="Filtrer par nom ou type..." 
                                   value="{{ request()->search }}">
                            <button type="submit" class="btn btn-dark px-4">Filtrer</button>
                            @if(request()->search)
                                <a href="{{ route('boissons.index') }}" class="btn btn-outline-secondary ms-2">Reset</a>
                            @endif
                        </form>
                    </div>
                    <div class="col-md-4 text-end">
                        <a href="{{ route('boissons.create') }}" class="btn btn-primary fw-bold">+ AJOUTER</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4">Nom</th>
                            <th>Type</th>
                            <th>État du Stock</th>
                            <th>Prix Unitaire</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($boissons as $boisson)
                            <tr>
                                <td class="ps-4 fw-bold">{{ $boisson->nom }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $boisson->type }}</span></td>
                                <td>
                                    @if($boisson->quantite <= 0)
                                        <span class="badge bg-danger px-3">Rupture</span>
                                    @elseif($boisson->quantite <= 10)
                                        <span class="badge bg-warning text-dark px-3">Critique: {{ $boisson->quantite }}</span>
                                    @else
                                        <span class="badge bg-success px-3">{{ $boisson->quantite }}</span>
                                    @endif
                                </td>
                                <td>{{ number_format($boisson->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                                <td class="text-center">
                                    <a href="{{ route('boissons.edit', $boisson->id) }}" class="btn btn-sm btn-info text-white">Éditer</a>
                                    <form action="{{ route('boissons.destroy', $boisson->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">X</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">Aucune boisson.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('myChart');
        new Chart(ctx, {
            type: 'doughnut', // Type de graphique (Cercle)
            data: {
                labels: {!! json_encode($stats['chart_labels']) !!},
                datasets: [{
                    data: {!! json_encode($stats['chart_data']) !!},
                    backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#6610f2', '#fd7e14'],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
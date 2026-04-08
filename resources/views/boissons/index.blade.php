<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distribution en Gros - Groupe 05</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .card-stat { border: none; border-radius: 12px; transition: 0.3s; }
        .card-stat:hover { transform: scale(1.02); }
        #myChart { max-height: 250px; }
        .hero-banner {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url("{{ asset('images/cave_boutique.png') }}");
            background-size: cover;
            background-position: center;
            height: 350px;
            border-radius: 15px;
            display: flex;
            align-items: flex-end;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark mb-0 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('boissons.index') }}">🚢 CENTRE DE DISTRIBUTION | GROUPE 05</a>
            @auth
            <div class="text-white small">Responsable : <strong>{{ auth()->user()->name }}</strong></div>
            @endauth
        </div>
    </nav>

    <div class="container mt-4">
        {{-- BANNIÈRE LOGISTIQUE --}}
        <div class="hero-banner">
            <div class="text-white">
                <h1 class="fw-bold display-5">GROUPE 05 - LOGISTIQUE & GROS</h1>
                <p class="lead">Gestion des stocks de masse et distribution régionale (Burkina Faso)</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- 1. BLOC STATISTIQUES SÉCURISÉ --}}
        @auth
            @if(auth()->user()->role === 'admin' && isset($stats))
                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card card-stat bg-primary text-white shadow h-100">
                                    <div class="card-body text-center d-flex flex-column justify-content-center">
                                        <small>Références en Stock</small>
                                        <h2 class="fw-bold">{{ $stats['nb_boissons'] ?? 0 }}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-stat bg-success text-white shadow h-100">
                                    <div class="card-body text-center d-flex flex-column justify-content-center">
                                        <small>Volume Total (Unités)</small>
                                        <h2 class="fw-bold">{{ $stats['total_stock'] ?? 0 }}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card card-stat bg-dark text-warning shadow border-warning border-start border-5">
                                    <div class="card-body text-center">
                                        <small>Valeur Inventaire</small>
                                        <h2 class="fw-bold">{{ number_format($stats['valeur_cave'] ?? 0, 0, ',', ' ') }} FCFA</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            @endif
        @endauth

        {{-- 2. RECHERCHE ET TABLEAU (RESTE DU CODE) --}}
        <div class="card border-0 shadow-sm mb-4 p-3 text-center">
            <h4>Accès aux Modules</h4>
            <div class="d-flex justify-content-center gap-2 mt-3">
                <a href="{{ route('boissons.index') }}" class="btn btn-dark">Inventaire</a>
                @if(isset($boissons))
                    {{-- Si tu as une route vente, ajoute la ici --}}
                @endif
            </div>
        </div>
    </div>

    {{-- SCRIPT GRAPHIQUE SÉCURISÉ --}}
    @if(isset($stats))
    <script>
        const ctx = document.getElementById('myChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($stats['chart_labels'] ?? []) !!},
                    datasets: [{
                        data: {!! json_encode($stats['chart_data'] ?? []) !!},
                        backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545'],
                        borderWidth: 2
                    }]
                }
            });
        }
    </script>
    @endif
</body>
</html>
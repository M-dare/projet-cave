@extends('layouts.app')

@section('content')
<div class="container">
    {{-- 1. Affichage des messages de succès --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Succès !</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- 2. Affichage des messages d'erreur (ex: Stock insuffisant) --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Erreur !</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- 3. Tableau de l'historique --}}
    <div class="card shadow border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Historique des Ventes</h5>
            <a href="{{ route('ventes.create') }}" class="btn btn-success btn-sm">
                <i class="bi bi-plus-circle"></i> Nouvelle Vente
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover mt-3 text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Boisson</th>
                            <th>Vendeur</th>
                            <th>Quantité</th>
                            <th>Total (FCFA)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ventes as $vente)
                        <tr>
                            <td>{{ $vente->created_at->format('d/m/Y H:i') }}</td>
                            <td><span class="badge bg-info text-dark">{{ $vente->boisson->nom ?? 'Inconnue' }}</span></td>
                            <td>{{ $vente->user->name ?? 'Anonyme' }}</td>
                            <td>{{ $vente->quantite }}</td>
                            <td class="fw-bold">{{ number_format($vente->prix_total, 0, ',', ' ') }}</td>
                            <td>
                                <form action="{{ route('ventes.destroy', $vente->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment annuler cette vente ? Cela remettra les produits en stock.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        Annuler
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-muted py-4">Aucune vente enregistrée pour le moment.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
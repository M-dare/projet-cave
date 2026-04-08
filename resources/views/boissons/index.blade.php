@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    {{-- 1. BANNIÈRE LOGISTIQUE --}}
    <div class="card shadow border-0 mb-4 overflow-hidden" style="border-radius: 15px;">
        <div class="position-relative">
            <img src="{{ asset('images/charge.png') }}" alt="Bannière" style="width: 100%; height: 250px; object-fit: cover; filter: brightness(0.6);">
            <div class="card-img-overlay d-flex flex-column justify-content-center text-white px-5">
                <h1 class="fw-bold display-5">GROUPE 05 - LOGISTIQUE & GROS</h1>
                <p class="lead">Gestion des stocks de masse et distribution régionale (Burkina Faso)</p>
            </div>
        </div>
    </div>

    {{-- 2. STATISTIQUES (Widgets) --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white shadow border-0 p-3 text-center">
                <small>Références en Stock</small>
                <h2 class="fw-bold">26</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white shadow border-0 p-3 text-center">
                <small>Volume Total (Unités)</small>
                <h2 class="fw-bold">2 153</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-dark text-warning shadow border-0 p-3 text-center">
                <small>Valeur Inventaire</small>
                <h2 class="fw-bold text-uppercase">3 225 250 FCFA</h2>
            </div>
        </div>
    </div>

    {{-- 3. LE TABLEAU DES BOISSONS (Ce qui manquait !) --}}
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
                            <th>Image</th>
                            <th>Désignation</th>
                            <th>Catégorie</th>
                            <th>Prix Unitaire</th>
                            <th>Stock</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($boissons as $boisson)
                        <tr>
                            <td>
                                <img src="{{ asset('storage/'.$boisson->image) }}" class="rounded" width="40" height="40" style="object-fit: cover;">
                            </td>
                            <td class="fw-bold">{{ $boisson->nom }}</td>
                            <td><span class="badge bg-secondary">{{ $boisson->categorie }}</span></td>
                            <td>{{ number_format($boisson->prix, 0, ',', ' ') }} FCFA</td>
                            <td>
                                @if($boisson->stock <= 5)
                                    <span class="text-danger fw-bold">{{ $boisson->stock }} (Alerte !)</span>
                                @else
                                    {{ $boisson->stock }}
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('boissons.edit', $boisson->id) }}" class="btn btn-sm btn-outline-info">Modifier</a>
                                <form action="{{ route('boissons.destroy', $boisson->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer ?')">X</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Aucune boisson trouvée dans la base de données.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
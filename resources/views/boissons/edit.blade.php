@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Modifier la Boisson : {{ $boisson->nom }}</h3>
                    <a href="{{ route('boissons.index') }}" class="btn btn-sm btn-light">Retour</a>
                </div>

                <div class="card-body">
                    <!-- Affichage des erreurs si la validation échoue -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Formulaire de modification -->
                    <form action="{{ route('boissons.update', $boisson->id) }}" method="POST">
                        @csrf
                        @method('PUT') <!-- Indispensable pour la mise à jour -->

                        <!-- On garde la catégorie par défaut (ID 1) -->
                        <input type="hidden" name="categorie_id" value="1"> 

                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom de la boisson</label>
                            <input type="text" name="nom" class="form-control" id="nom" 
                                   value="{{ $boisson->nom }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Type / Catégorie</label>
                            <select name="type" id="type" class="form-select">
                                <option value="Sucrerie" {{ $boisson->type == 'Sucrerie' ? 'selected' : '' }}>Sucrerie</option>
                                <option value="Alcool" {{ $boisson->type == 'Alcool' ? 'selected' : '' }}>Alcool</option>
                                <option value="Eau" {{ $boisson->type == 'Eau' ? 'selected' : '' }}>Eau</option>
                                <option value="Jus" {{ $boisson->type == 'Jus' ? 'selected' : '' }}>Jus</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="quantite" class="form-label">Quantité en stock</label>
                                <input type="number" name="quantite" class="form-control" id="quantite" 
                                       value="{{ $boisson->quantite }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="prix_unitaire" class="form-label">Prix Unitaire (FCFA)</label>
                                <input type="number" step="0.01" name="prix_unitaire" class="form-control" id="prix_unitaire" 
                                       value="{{ $boisson->prix_unitaire }}" required>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-info text-white">Mettre à jour la boisson</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
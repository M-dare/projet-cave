@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Ajouter une Boisson</h3>
                    <a href="{{ route('boissons.index') }}" class="btn btn-sm btn-light">Retour</a>
                </div>

                <div class="card-body">
                    <form action="{{ route('boissons.store') }}" method="POST">
                        @csrf
                        <input type="number" name="categorie_id" value="1"> 

                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom de la boisson</label>
                            <input type="text" name="nom" class="form-control" id="nom" placeholder="Ex: Beaufort" required>
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Type / Catégorie</label>
                            <select name="type" id="type" class="form-select">
    <option value="Alcool">Alcool</option>
    <option value="Bière">Bière</option>
    <option value="Eau">Eau</option>
    <option value="Energie">Energie</option>
    <option value="Jus">Jus</option>
    <option value="Sucrerie">Sucrerie</option>
</select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="quantite" class="form-label">Quantité en stock</label>
                                <input type="number" name="quantite" class="form-control" id="quantite" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="prix_unitaire" class="form-label">Prix Unitaire (FCFA)</label>
                                <input type="number" step="0.01" name="prix_unitaire" class="form-control" id="prix_unitaire" required>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success text-white">Enregistrer la boisson</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
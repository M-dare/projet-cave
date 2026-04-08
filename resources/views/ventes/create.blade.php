@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Nouvelle Vente - Gestion de Cave</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('ventes.store') }}" method="POST">
                        @csrf

                        {{-- Choix de la Boisson --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Boisson</label>
                            <select name="boisson_id" id="boisson_id" class="form-select" required>
                                <option value="">-- Choisir la boisson --</option>
                                @foreach($boissons as $b)
                                    <option value="{{ $b->id }}" data-prix="{{ $b->prix_unitaire }}">
                                        {{ $b->nom }} (Stock: {{ $b->quantite }}) - {{ $b->prix_unitaire }} FCFA
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Choix de l'Utilisateur (Modifiable) --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nom du Vendeur / Client</label>
                            <select name="user_id" class="form-select" required>
                                @foreach($users as $u)
                                    <option value="{{ $u->id }}" {{ auth()->id() == $u->id ? 'selected' : '' }}>
                                        {{ $u->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Quantité</label>
                                <input type="number" name="quantite" id="quantite" class="form-control" min="1" value="1" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Total à payer (FCFA)</label>
                                <input type="text" id="total_display" class="form-control bg-warning fw-bold" readonly value="0">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('ventes.index') }}" class="btn btn-secondary">Retour</a>
                            <button type="submit" class="btn btn-success px-5">Valider la Vente</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const bSelect = document.getElementById('boisson_id');
    const qInput = document.getElementById('quantite');
    const tDisplay = document.getElementById('total_display');

    function updatePrice() {
        const prix = bSelect.options[bSelect.selectedIndex].getAttribute('data-prix') || 0;
        const qte = qInput.value || 0;
        tDisplay.value = (prix * qte).toLocaleString();
    }

    bSelect.addEventListener('change', updatePrice);
    qInput.addEventListener('input', updatePrice);
</script>
@endsection
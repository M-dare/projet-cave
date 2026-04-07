@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card shadow border-0">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Tableau de Bord - Gestion de Cave') }}</h5>
                    <span class="badge bg-success">Connecté en tant que Chef de Projet</span>
                </div>

                <div class="card-body bg-light">
                    <div class="row text-center mt-4">
                        
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm border-primary">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">📦 Stock Boissons</h5>
                                    <p class="card-text">Gérer l'inventaire des boissons de la cave.</p>
                                    <a href="{{ route('boissons.index') }}" class="btn btn-outline-primary w-100">Accéder</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm border-success">
                                <div class="card-body">
                                    <h5 class="card-title text-success">💰 Ventes</h5>
                                    <p class="card-text">Enregistrer et consulter l'historique des ventes.</p>
                                    <a href="#" class="btn btn-outline-success w-100">Bientôt disponible</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm border-info">
                                <div class="card-body">
                                    <h5 class="card-title text-info">👤 Mon Profil</h5>
                                    <p class="card-text">Modifier vos informations et mot de passe.</p>
                                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-info w-100">Gérer mon profil</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm border-warning">
                                <div class="card-body">
                                    <h5 class="card-title text-warning">👥 Utilisateurs</h5>
                                    <p class="card-text">Gérer les accès des clients et administrateurs.</p>
                                    <a href="{{ route('users.index') }}" class="btn btn-outline-warning w-100">Gérer</a>
                                </div>
                            </div>
                        </div>

                    </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
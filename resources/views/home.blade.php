@extends('layouts.app')
<style>
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-10px); /* Soulève la carte de 10px */
        box-shadow: 0 10px 20px rgba(0,0,0,0.2) !important; /* Ajoute une ombre plus forte */
    }
    .btn {
        transition: all 0.3s ease;
    }
    .btn:hover {
        letter-spacing: 1px; /* Écarte légèrement les lettres du bouton */
    }
</style>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            
            {{-- 1. BANNIÈRE D'ILLUSTRATION --}}
            <div class="card shadow border-0 mb-4">
                <div class="position-relative">
                    {{-- L'image de la cave que tu as envoyée --}}
                    <img src="{{ asset('images/cave_boutique.png') }}" 
                         alt="Illustration de la cave" 
                         class="card-img-top" 
                         style="height: 400px; object-fit: cover; border-radius: 8px 8px 0 0;">
                    
                    {{-- Dégradé sombre pour rendre le texte lisible --}}
                    <div class="card-img-overlay d-flex align-items-end" 
                         style="background: linear-gradient(transparent, rgba(0,0,0,0.7)); border-radius: 8px 8px 0 0;">
                        <div class="px-3 pb-3">
                            <h1 class="text-white fw-bold" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.9);">
                                Bienvenue dans votre espace de gestion
                            </h1>
                            <p class="text-white-50 mb-0">Optimisez le pilotage de votre cave en temps réel.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. LE TABLEAU DE BORD ET MODULES --}}
            <div class="card shadow border-0">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-tachometer-alt me-2"></i>{{ __('Tableau de Bord - Gestion de Cave') }}
                    </h5>
                    <span class="badge bg-success px-3 py-2">
                        <i class="fas fa-check-circle me-1"></i>Connecté en tant que Chef de Projet
                    </span>
                </div>

                <div class="card-body bg-light p-4">
                    <div class="row text-center">
                        
                        {{-- MODULE STOCK --}}
                        <div class="col-md-3 mb-4">
                            <div class="card h-100 shadow-sm border-primary transition-hover">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-primary fw-bold mb-3">📦 Stock Boissons</h5>
                                    <p class="card-text small text-muted flex-grow-1">Gérer l'inventaire des boissons de la cave.</p>
                                    <a href="{{ route('boissons.index') }}" class="btn btn-primary w-100 mt-3">Accéder</a>
                                </div>
                            </div>
                        </div>

                        {{-- MODULE VENTES --}}
                        <div class="col-md-3 mb-4">
                            <div class="card h-100 shadow-sm border-success transition-hover">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-success fw-bold mb-3">💰 Ventes</h5>
                                    <p class="card-text small text-muted flex-grow-1">Enregistrer et consulter l'historique des ventes.</p>
                                    <a href="{{ route('ventes.index') }}" class="btn btn-success text-white w-100 mt-3">Accéder</a>
                                </div>
                            </div>
                        </div>

                        {{-- MODULE UTILISATEURS --}}
                        <div class="col-md-3 mb-4">
                            <div class="card h-100 shadow-sm border-warning transition-hover">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-warning fw-bold mb-3">👥 Utilisateurs</h5>
                                    <p class="card-text small text-muted flex-grow-1">Gérer les accès des clients et administrateurs.</p>
                                    <a href="{{ route('users.index') }}" class="btn btn-warning text-white w-100 mt-3">Gérer</a>
                                </div>
                            </div>
                        </div>

                        {{-- MODULE PROFIL --}}
                        <div class="col-md-3 mb-4">
                            <div class="card h-100 shadow-sm border-info transition-hover">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-info fw-bold mb-3">👤 Mon Profil</h5>
                                    <p class="card-text small text-muted flex-grow-1">Modifier vos infos personnelles et mot de passe.</p>
                                    <a href="{{ route('profile.edit') }}" class="btn btn-info text-white w-100 mt-3">Mon compte</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div> {{-- Fin Card principale --}}
        </div>
    </div>
</div>

<style>
    /* Petit effet de survol pour rendre l'interface dynamique */
    .transition-hover:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>
@endsection
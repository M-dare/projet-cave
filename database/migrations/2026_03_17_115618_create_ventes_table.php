<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Exécuter la migration pour créer la table des ventes
    public function up(): void
    {
        Schema::create('ventes', function (Blueprint $table) {
            // ID de la vente
            $table->id();

            // Lien avec la table boissons
            $table->foreignId('boisson_id')
                  ->constrained('boissons')
                  ->onDelete('cascade');

            // Lien avec l'utilisateur (le gérant)
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Informations de la transaction
            $table->integer('quantite'); // Nombre de bouteilles
            $table->decimal('prix_total', 10, 2); // Prix total calculé
            $table->decimal('montant_recu', 10, 2); // Argent donné par le client
            $table->decimal('monnaie_rendue', 10, 2)->default(0); // Reste à rendre
            $table->string('mode_paiement')->default('Espèces'); // Mode de règlement
            
            // Dates de création et modification
            $table->timestamps();
        });
    }

    // Annuler la migration (Supprimer la table)
    public function down(): void
    {
        Schema::dropIfExists('ventes');
    }
};
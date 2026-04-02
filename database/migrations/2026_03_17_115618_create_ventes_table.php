<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //Exécuter la migration.
    public function up(): void
    {
        Schema::create('ventes', function (Blueprint $table) {
            $table->id(); // Ceci crée automatiquement l'ID de la vente (id_vente)

            //RELATION AVEC L'UTILISATEUR (Le Gérant)
            // On lie la vente à l'utilisateur qui l'a saisie.
            // La table 'users' est créée par défaut par Laravel.
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            //RELATION AVEC LA COMMANDE
            $table->foreignId('commande_id')
                  ->constrained('commandes')
                  ->onDelete('cascade');

            //ATTRIBUTS FINANCIERS
            $table->decimal('montant_total', 10, 2);
            $table->decimal('montant_recu', 10, 2);
            $table->decimal('monnaie_rendue', 10, 2)->default(0);
            $table->string('mode_paiement')->default('Espèces');
            
            $table->timestamps(); // Date et heure précises de la vente
        });
    }
    //Annuler la migration.
    
    public function down(): void
    {
        Schema::dropIfExists('ventes');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //Exécuter la migration pour créer la table.
    public function up(): void
    {
        // Nom de la table en minuscules (convention Laravel)
        Schema::create('commandes', function (Blueprint $table) {
            $table->id(); // Identifiant unique de la commande (clé primaire)
            
            // --- RELATION AVEC LA TABLE CLIENTS ---
            // On lie la commande à un client existant.
            // 'constrained' cherche automatiquement la table 'clients'.
            // 'onDelete(cascade)' supprime les commandes si le client est supprimé.
            $table->foreignId('client_id')
                  ->constrained('clients')
                  ->onDelete('cascade');

            $table->date('date_commande'); // La date de l'achat
            
            // Le montant total de la commande (ex: 2500.50)
            $table->decimal('montant_total', 10, 2)->default(0); 
            
            // Statut pour savoir si la commande est payée ou non
            $table->string('statut')->default('en attente'); 

            $table->timestamps(); // Ajoute les colonnes created_at et updated_at
        });
    }
    //Annuler la migration (supprimer la table).
    
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
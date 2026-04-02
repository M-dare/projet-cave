<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Exécuter la migration pour créer la table.
     
    public function up(): void
    {
    
        Schema::create('boissons', function (Blueprint $table) {
            $table->id(); // Identifiant unique (clé primaire)
            $table->string('nom'); // Nom de la boisson (ex: Coca, Castel)
            $table->string('type'); // Affiche les types (ex: sucrerie, alcool...)
            $table->integer('quantite'); // quantité de boissons stocké
            $table->text('description')->nullable(); // Description optionnelle
            $table->decimal('prix_unitaire', 10, 2); // Prix (ex: 500.00)
            
            // --- RELATION AVEC LA TABLE CATEGORIES ---
            // 'categorie_id' fera le lien avec la table 'categories' (en minuscules)
            // 'constrained' vérifie que la catégorie existe
            // 'onDelete(cascade)' : si on supprime une catégorie, ses boissons sont supprimées
            $table->foreignId('categorie_id')
                  ->constrained('categories') 
                  ->onDelete('cascade');

            $table->timestamps(); // Ajoute 'created_at' et 'updated_at'
        });
    }
    // Annuler la migration (supprimer la table).
    public function down(): void
    {
        Schema::dropIfExists('boissons');
    }
};
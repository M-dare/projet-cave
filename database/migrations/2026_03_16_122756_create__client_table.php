<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     //Route de migration.
     
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id(); // Identifiant unique
            $table->string('nom'); // Nom du client
            $table->string('prenom'); // Prénom du client
            $table->string('telephone')->nullable(); // Téléphone (peut être vide)
            $table->string('email')->unique()->nullable(); // Email (doit être unique)
            $table->timestamps();
            // Ajoute created_at(Crée une colonne pour enregistrer la date et l'heure de création)
            //  updated_at(Crée une colonne pour enregistrer la date et l'heure de la dernière mise à jour)
        });
    }
     //.
     
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés en masse.
     * Mise à jour pour le Groupe 05 : On inclut tous les champs de la migration.
     */
    protected $fillable = [
        'boisson_id',
        'user_id',
        'quantite',
        'prix_total',
        'montant_recu',
        'monnaie_rendue', // Ajouté pour correspondre à ta migration
        'mode_paiement',  // Ajouté pour correspondre à ta migration
    ];

    /**
     * Relation avec la table boissons
     */
    public function boisson()
    {
        return $this->belongsTo(Boisson::class);
    }

    /**
     * Relation avec la table users
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
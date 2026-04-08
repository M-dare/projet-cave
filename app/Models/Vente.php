<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés en masse (Mass Assignment).
     * Note pour le Groupe 05 : 'montant_recu' est désormais inclus pour
     * corriger l'erreur SQL "Field doesn't have a default value".
     */
    protected $fillable = [
        'boisson_id',
        'user_id',
        'quantite',
        'prix_total',
        'montant_recu', // Ajouté pour correspondre à la structure de la table
    ];

    /**
     * Relation avec la table boissons
     * Une vente appartient à une boisson spécifique.
     */
    public function boisson()
    {
        return $this->belongsTo(Boisson::class);
    }

    /**
     * Relation avec la table users
     * Une vente est enregistrée par un utilisateur (Vendeur/Chef de projet).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
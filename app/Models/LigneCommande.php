<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LigneCommande extends Model
{
    // On précise le nom de la table car il y a un underscore
    protected $table = 'ligne_commandes';

    // Les champs que l'on peut remplir
    protected $fillable = [
        'commande_id', 
        'boisson_id', 
        'quantite', 
        'prix_unitaire', 
        'sous_total'
    ];

    // Une ligne appartient à une commande
    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class);
    }

    // Une ligne concerne une boisson
    public function boisson(): BelongsTo
    {
        return $this->belongsTo(Boisson::class);
    }
}
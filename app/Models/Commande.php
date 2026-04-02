<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Commande extends Model
{
    protected $fillable = ['client_id', 'date_commande', 'montant_total', 'statut'];

    // Une commande appartient à un client
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    // Une commande contient plusieurs lignes (boissons)
    public function lignes(): HasMany
    {
        return $this->hasMany(LigneCommande::class);
    }
}
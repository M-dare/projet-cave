<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vente extends Model
{
    protected $fillable = [
        'user_id', 
        'commande_id', 
        'montant_total', 
        'montant_recu', 
        'monnaie_rendue', 
        'mode_paiement'
    ];

    // La vente est liée au gérant (user)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // La vente est liée à une commande
    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class);
    }
}
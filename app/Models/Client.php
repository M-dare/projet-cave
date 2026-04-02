<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    // Champs autorisés pour l'enregistrement
    protected $fillable = ['nom', 'prenom', 'telephone', 'email'];

    // Un client peut passer plusieurs commandes
    public function commandes(): HasMany
    {
        return $this->hasMany(Commande::class);
    }
}
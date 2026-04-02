<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boisson extends Model
{
    use HasFactory;

    // Cette ligne autorise Laravel à remplir ces colonnes dans la base de données
    protected $fillable = [
        'nom', 
        'type', 
        'quantite',
        'description' ,
        'prix_unitaire',
        'categorie_id'
    ];
}
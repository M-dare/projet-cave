<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Boisson;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File; // Import indispensable pour lire le fichier

class BoissonSeeder extends Seeder
{
    public function run(): void
    {
        // 1. On vide la table proprement
        Schema::disableForeignKeyConstraints();
        Boisson::truncate();
        Schema::enableForeignKeyConstraints();

        // 2. On récupère le chemin du fichier JSON
        $chemin = database_path('seeders/boissons.json');

        // 3. On vérifie si le fichier existe avant de le lire
        if (File::exists($chemin)) {
            $json = File::get($chemin);
            $data = json_decode($json, true); // true pour avoir un tableau PHP

            foreach ($data as $item) {
                Boisson::create($item);
            }
        }
    }
}
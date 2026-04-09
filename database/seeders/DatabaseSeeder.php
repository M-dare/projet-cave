<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Nettoyage pour éviter les erreurs de doublons
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        // 1. LE COMPTE DU PROFESSEUR
        User::factory()->create([
            'name' => 'Correcteur UVBF',
            'email' => 'prof@uvbf.bf',
            'password' => Hash::make('uvbf2026'),
            'role' => 'admin',
        ]);

        // 2. VOS COMPTES
        User::factory()->create(['name' => 'Hadaré BAGUIAN', 'email' => 'hadare@cave.bf', 'password' => Hash::make('password123'), 'role' => 'admin']);
        User::factory()->create(['name' => 'Walid OUEDRAOGO', 'email' => 'walid@cave.bf', 'password' => Hash::make('password123'), 'role' => 'admin']);
        User::factory()->create(['name' => 'Abdoul-Fatasé ILBOUDO', 'email' => 'abdoul@cave.bf', 'password' => Hash::make('password123'), 'role' => 'admin']);

        // 3. APPEL DU SEEDER DES BOISSONS
        $this->call([
            BoissonSeeder::class,
        ]);
    }
}
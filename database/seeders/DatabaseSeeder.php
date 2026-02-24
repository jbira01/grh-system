<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Création des rôles Spatie (très important pour Filament)
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'employe']); // On crée juste le nom du rôle pour plus tard

        // 2. Création de votre compte Administrateur
        $admin = User::firstOrCreate(
            ['email' => 'admin@grh.com'],
            [
                'nom' => 'admin',
                'prenom' => 'admin',
                'password' => Hash::make('password123'),
                'etat' => 'actif',
            ]
        );
        
        // 3. Attribution du rôle Admin à ce compte
        $admin->assignRole($adminRole);
    }
}
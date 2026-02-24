<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Nettoyer le cache des permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. VIDER LES TABLES (Pour éviter les erreurs de doublons si on relance)
        // On désactive temporairement les clés étrangères pour pouvoir vider
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        // On ne vide pas 'users' pour ne pas perdre votre admin si vous avez d'autres seeders
        // Mais on supprime l'user admin spécifique s'il existe déjà pour le recréer propre
        User::where('email', 'admin@grh.com')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 3. Créer les PERMISSIONS
        $permissions = [
            'voir-employes',
            'creer-employe',
            'editer-employe',
            'supprimer-employe',
            'voir-dossier-complet',
            'gerer-paie',
            'voir-salaires',
            'imprimer-bulletin',
            'gerer-contrats',
            'gerer-formations',
            'gerer-sanctions',
            'gerer-recrutement',
            'gerer-utilisateurs',
            'gerer-roles',
            'voir-logs',
        ];

        foreach ($permissions as $permission) {
            // firstOrCreate évite les erreurs si jamais ça existe encore
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 4. Créer les RÔLES et assigner les permissions

        // Rôle : EMPLOYE
        $roleEmploye = Role::create(['name' => 'employe']);

        // Rôle : MANAGER
        $roleManager = Role::create(['name' => 'manager']);
        // On assigne permission par permission pour éviter les erreurs de tableau
        $roleManager->givePermissionTo('voir-employes');
        $roleManager->givePermissionTo('gerer-recrutement');

        // Rôle : RH
        $roleRH = Role::create(['name' => 'rh']);
        $roleRH->givePermissionTo([
            'voir-employes', 'creer-employe', 'editer-employe', 'voir-dossier-complet',
            'gerer-contrats', 'gerer-formations', 'gerer-sanctions', 'imprimer-bulletin',
            'gerer-paie', 'voir-salaires'
        ]);

        // Rôle : ADMIN
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleAdmin->givePermissionTo(Permission::all());

        // 5. Créer l'utilisateur ADMIN
        $user = User::create([
            'nom' => 'Admin',
            'prenom' => 'Systeme',
            'email' => 'admin@grh.com',
            'password' => Hash::make('password123'),
            'etat' => 'actif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user->assignRole($roleAdmin);
    }
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employes', function (Blueprint $table) {
            $table->id();

            // Lien vers la table de connexion (users)
            // Si on supprime l'utilisateur, on supprime la fiche employé (cascade)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('matricule')->unique(); // Ex: EMP-2024-001

            // Lien vers Départements et Postes (qu'on vient de créer)
            // Si on supprime un département, le champ devient NULL (on ne supprime pas l'employé)
            $table->foreignId('departement_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('poste_id')->nullable()->constrained()->nullOnDelete();

            $table->date('date_embauche');

            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employes');
    }
};

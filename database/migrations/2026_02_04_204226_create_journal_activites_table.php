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
        Schema::create('journal_activites', function (Blueprint $table) {
            $table->id();
            
            // L'utilisateur qui a fait l'action
            $table->foreignId('utilisateur_id')->nullable()->constrained('users')->nullOnDelete();
            
            $table->string('action'); // Ex: "creation", "modification", "suppression"
            
            // Sur quel objet ? (Ex: Contrat #42)
            $table->morphs('objet');
            
            // Infos techniques
            $table->string('ip')->nullable();
            $table->string('user_agent')->nullable(); // Navigateur
            
            // Pour voir ce qui a changé (Avant/Après)
            $table->json('donnees_avant')->nullable();
            $table->json('donnees_apres')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_activites');
    }
};

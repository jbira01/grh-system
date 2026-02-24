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
        Schema::create('recrutement_internes', function (Blueprint $table) {
            $table->id();
            
            // Le poste visé par l'employé
            $table->foreignId('poste_id')->constrained()->onDelete('cascade');
            
            // L'employé qui postule
            $table->foreignId('employe_id')->constrained()->onDelete('cascade');
            
            // État de la candidature
            // Ex: 'en_attente', 'entretien', 'approuve', 'rejete'
            $table->string('statut')->default('en_attente');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recrutement_internes');
    }
};

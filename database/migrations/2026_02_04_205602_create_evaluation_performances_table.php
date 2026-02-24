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
        Schema::create('evaluation_performances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employe_id')->constrained()->onDelete('cascade');
            
            // Qui a fait l'évaluation ? (Souvent le manager)
            $table->foreignId('evaluateur_id')->nullable()->constrained('users');
            
            $table->string('periode'); // Ex: "2025-Q1" ou "Annuelle 2025"
            $table->decimal('note_globale', 4, 2); // Ex: 18.50
            $table->text('commentaire')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_performances');
    }
};

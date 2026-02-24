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
        Schema::create('pointages', function (Blueprint $table) {
            $table->id();
            // Lier à l'employé
            $table->foreignId('employe_id')->constrained()->cascadeOnDelete();
            
            // La date du jour
            $table->date('date');
            
            // Les heures de pointage (peuvent être nulles tant que l'action n'est pas faite)
            $table->time('heure_arrivee')->nullable();
            $table->time('heure_depart')->nullable();
            
            $table->timestamps();

            // Sécurité : Un employé ne peut avoir qu'une seule fiche de pointage par jour
            $table->unique(['employe_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pointages');
    }
};

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
        Schema::create('contrats', function (Blueprint $table) {
            $table->id();
            // Lien vers l'employé
            $table->foreignId('employe_id')->constrained()->onDelete('cascade');
            
            $table->string('type'); // CDI, CDD, Stage, etc.
            $table->date('date_debut');
            $table->date('date_fin')->nullable(); // Nullable car un CDI n'a pas forcément de date de fin
            $table->decimal('salaire', 10, 2); // Ex: 15000.00
            
            // Note sur 'piece_jointe_id' : 
            // Votre convention suggère d'utiliser le polymorphisme (table pieces_jointes).
            // Nous n'ajoutons donc pas de colonne ici, le fichier se liera au contrat plus tard.
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contrats');
    }
};

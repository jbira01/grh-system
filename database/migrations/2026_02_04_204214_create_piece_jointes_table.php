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
        Schema::create('piece_jointes', function (Blueprint $table) {
            $table->id();
            
            // Crée automatiquement 'objet_id' (bigint) et 'objet_type' (string)
            $table->morphs('objet'); 
            
            $table->string('nom_fichier'); // Ex: contrat_2024.pdf
            $table->string('chemin');      // Ex: uploads/contrats/xyz.pdf
            $table->string('mime');        // Ex: application/pdf
            $table->unsignedBigInteger('taille'); // En octets
            
            // Qui a uploadé le fichier ?
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('piece_jointes');
    }
};

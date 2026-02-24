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
        Schema::create('bulletin_paies', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('paie_id')->constrained()->onDelete('cascade');
            
            // Lien vers la table polymorphique créée précédemment
            // Note: On pointe vers l'ID de la pièce jointe
            $table->foreignId('piece_jointe_id')->constrained()->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bulletin_paies');
    }
};

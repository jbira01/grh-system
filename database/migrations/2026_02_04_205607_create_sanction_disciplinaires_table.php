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
        Schema::create('sanction_disciplinaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employe_id')->constrained()->onDelete('cascade');
            
            $table->string('type'); // Avertissement, Blâme, Mise à pied...
            $table->text('motif');
            $table->date('date');
            
            // Lien vers la pièce jointe (PV de sanction) via ID direct ou polymorphe
            // Votre schéma suggérait un lien direct ici, mais le polymorphisme est plus flexible.
            // Gardons simple comme votre excel :
            $table->foreignId('piece_jointe_id')->nullable()->constrained()->nullOnDelete();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sanction_disciplinaires');
    }
};

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
        Schema::create('conges', function (Blueprint $table) {
            $table->id();
            // Lien avec l'employé
            $table->foreignId('employe_id')->constrained()->cascadeOnDelete();
            
            $table->string('type'); // Payé, Maladie, Sans solde...
            $table->date('date_debut');
            $table->date('date_fin');
            $table->integer('jours')->nullable(); // Nombre de jours calculé
            $table->text('motif')->nullable();
            
            // Workflow de validation
            $table->string('statut')->default('en_attente'); // en_attente, accepte, refuse
            $table->text('commentaire_admin')->nullable(); // Si refusé, pourquoi ?
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conges');
    }
};

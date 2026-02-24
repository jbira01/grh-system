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
        Schema::create('paies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employe_id')->constrained()->onDelete('cascade');
            
            $table->string('mois'); // Ex: "01", "Janvier"
            $table->integer('annee'); // Ex: 2026
            
            $table->decimal('salaire_brut', 10, 2);
            $table->decimal('deductions', 10, 2); // Total des retenues
            $table->decimal('net_a_payer', 10, 2);
            
            $table->string('statut')->default('brouillon'); // brouillon, paye, archive
            
            // Ajout conseillé pour stocker le détail (CNSS, AMO, IGR) sans poluer la table
            $table->json('donnees_calcul')->nullable(); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paies');
    }
};

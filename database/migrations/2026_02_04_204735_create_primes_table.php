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
        Schema::create('primes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employe_id')->constrained()->onDelete('cascade');
            
            $table->string('type'); // Ex: "Rendement", "Aid", "Ancienneté"
            $table->decimal('montant', 10, 2);
            $table->date('date'); // Date d'attribution
            
            // Optionnel : un champ pour dire si elle a déjà été payée ou non
            $table->boolean('payee')->default(false); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('primes');
    }
};

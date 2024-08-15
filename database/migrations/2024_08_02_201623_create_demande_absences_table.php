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
        Schema::create('demande_absences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employe_id')->constrained();
            $table->date('date_debut');
            $table->date('date_fin');
            $table->string('motif', 255);
            $table->enum('statut', ['en_attente', 'approuvee', 'refusee'])->default('en_attente');
            $table->timestamps();

            $table->index('employe_id');
            $table->index('date_debut');
            $table->index('date_fin');
            $table->index('statut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demande_absences');
    }
};
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
        Schema::create('employes', function (Blueprint $table) {
            $table->id();
            $table->string('prénom');
            $table->string('nom', 50);
            $table->string('email')->unique();
            $table->enum('sexe', ['masculin', 'féminin'])->nullable();
            $table->string('poste');
            $table->foreignId('departement_id')->constrained('departements');
            $table->string('contact', 20);
            $table->date('date_naissance');
            $table->date('date_embauche');
            $table->enum('statut', ['actif', 'absent', 'inactif']);
            $table->string('lieu_habitation');
            $table->string('nationalité', 50);
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

            $table->index('nom');
            $table->index('prénom');
            $table->index('statut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employes');
    }
};
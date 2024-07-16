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
            $table->string('nom', 50);
            $table->string('prenom', 100);
            $table->string('email', 191)->unique();
            $table->string('poste');
            $table->date('date_naissance');
            $table->date('date_embauche');
            $table->string('sexe', 10);
            $table->string('nationalite', 50);
            $table->string('lieu_habitation', 100);
            $table->string('contact', 25);
            $table->string('statut', 50);
            $table->string('departement_nom', 100);
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('departement_id')->constrained('departements');
            $table->foreignId('role_id')->constrained('roles');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('nom');
            $table->index('prenom');
            $table->index('date_embauche');
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
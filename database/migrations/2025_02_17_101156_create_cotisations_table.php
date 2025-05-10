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
        Schema::create('cotisations', function (Blueprint $table) {
            $table->unsignedBigInteger('idUser');
            $table->unsignedBigInteger('idTontine');
            $table->date('date_echeance');
            $table->integer('montant');
            $table->enum('moyen_paiement', ['OM', 'WAVE']);
            $table->string('statut')->default('en_attente');
            $table->timestamps();
        
            $table->primary(['idUser', 'idTontine', 'date_echeance']); // ✅ Ajout de date_echeance à la clé primaire
        
            $table->foreign('idUser')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('idTontine')->references('id')->on('tontines')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotisations');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tontine_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tontine_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('ordre_de_passage')->nullable();
            $table->string('statut')->default('actif'); // ou 'retiré', etc.
            $table->timestamps();

            $table->unique(['tontine_id', 'user_id']); // un participant ne peut pas s’inscrire deux fois à la même tontine
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tontine_participants');
    }
};

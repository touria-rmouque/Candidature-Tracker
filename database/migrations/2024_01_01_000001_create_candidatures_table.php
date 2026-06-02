<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('entreprise');
            $table->string('poste');
            $table->string('url_offre')->nullable();
            $table->string('statut')->default('envoyee');
            $table->string('priorite')->default('normale');
            $table->text('notes')->nullable();
            $table->date('date_candidature');
            $table->double('salair')->nullable();
            $table->string('fichier_path')->nullable();
            $table->string('fichier_nom')->nullable();
            $table->softDeletes(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidatures');
    }
};

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
        Schema::create('stagiaire', function (Blueprint $table) {
            // Inherit columns from the 'utilisateurs' table
            $table->id();
            $table->integer('user_id');
            $table->text('RapportStage')->nullable();
            $table->string('ProjetFinale')->nullable();
            //$table->string('Attestation_id')->references('id')->on('attestation')->onDelete('cascade')->nullable();
            $table->string('Equipe_id')->references('id')->on('equipe')->onDelete('cascade')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stagiaire');
    }
};

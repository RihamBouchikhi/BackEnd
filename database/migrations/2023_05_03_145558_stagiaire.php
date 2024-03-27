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
            $table->text('RapportStage');
            $table->string('ProjetFinale');
            //$table->string('Attestation_id')->references('id')->on('attestation')->onDelete('cascade')->nullable();
            $table->string('Form_id')->references('id')->on('formulaire')->onDelete('cascade')->nullable();
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

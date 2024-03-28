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
        Schema::create('attestation', function (Blueprint $table) {
            $table->id();
            $table->date('date') ;
            $table->foreignId('administrateur_id')->references('id')->on('administrateur')->onDelete('cascade');
            $table->foreignId('stagiaire_id')->references('id')->on('stagiaire')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attestation');
    }
};

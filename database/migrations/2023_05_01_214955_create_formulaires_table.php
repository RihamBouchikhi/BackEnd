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
        Schema::create('formulaires', function (Blueprint $table) {
            $table->id();
            $table->text('niveau-etude');
            $table->text('etablissement');
            $table->binary('CV');
            $table->binary('demande-stage');
            $table->date('date-debut');
            $table->date('date-fin');
            $table->foreignId('Offres_id')->constrained()->on('offres')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formulaires');
    }
};

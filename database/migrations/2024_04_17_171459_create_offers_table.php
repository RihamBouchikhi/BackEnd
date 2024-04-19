<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::disableForeignKeyConstraints();
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('sector');
            $table->string('experience');
            $table->string('skills');
            $table->string('deriction');
            $table->string('duration');
            $table->string('type');
            $table->boolean('visibility');
            $table->string('status');
            $table->string('ville');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};

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
        Schema::create('pokemon_species', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20);
            $table->unsignedBigInteger('primary_pokemon_id')->nullable();
            $table->timestamps();

            $table->foreign('primary_pokemon_id')->references('id')->on('pokemon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pokemon_species');
    }
};

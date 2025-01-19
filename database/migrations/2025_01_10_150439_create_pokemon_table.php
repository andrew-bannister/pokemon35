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
        Schema::create('pokemon', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('primary_type');
            $table->integer('secondary_type')->nullable();
            $table->string('category');
            $table->unsignedTinyInteger('base_hp');
            $table->unsignedTinyInteger('base_attack');
            $table->unsignedTinyInteger('base_defense');
            $table->unsignedTinyInteger('base_special_attack');
            $table->unsignedTinyInteger('base_special_defense');
            $table->unsignedTinyInteger('base_speed');
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pokemon');
    }
};

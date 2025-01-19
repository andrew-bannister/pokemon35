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
        Schema::create('type_effectiveness', function (Blueprint $table) {
            $table->id();
            $table->integer('attacking_type');
            $table->integer('defending_type');
            $table->boolean('super_effective');
            $table->boolean('not_very_effective');
            $table->boolean('no_effect');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_effectiveness');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->text('description');
            $table->integer('preparation_time')->nullable(); // en minutes
            $table->integer('cooking_time')->nullable(); // en minutes
            $table->string('difficulty')->nullable();// (très facile, facile, etc.)
            $table->string('cost')->nullable(); //(bon marché, etc.)
            $table->string('calories')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};

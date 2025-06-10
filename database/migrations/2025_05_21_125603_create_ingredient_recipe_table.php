<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ingredient_recipe', function (Blueprint $table) {
            $table->foreignId('ingredient_id')->constrained('ingredients');
            $table->foreignId('recipe_id')->constrained('recipes')->onDelete('cascade');
            $table->integer('quantity');
            $table->string('unity')->nullable();

            $table->primary(['ingredient_id', 'recipe_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ingredient_recipe');
    }
};

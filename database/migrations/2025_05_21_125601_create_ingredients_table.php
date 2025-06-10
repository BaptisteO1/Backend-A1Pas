<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('kcal')->nullable();
            $table->integer('matieres_grasses')->nullable();
            $table->integer('dont_acides_gras_saturés')->nullable();
            $table->integer('glucides')->nullable();
            $table->integer('dont_sucres')->nullable();
            $table->integer('proteines')->nullable();
            $table->integer('sel')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ingredients');
    }
};

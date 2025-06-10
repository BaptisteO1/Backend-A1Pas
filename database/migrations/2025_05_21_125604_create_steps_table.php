<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recipe_id')->constrained('recipes')->onDelete('cascade');;
            $table->text('description');
            $table->integer('order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('steps');
    }
};

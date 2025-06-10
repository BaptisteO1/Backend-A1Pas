<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    /** @use HasFactory<\Database\Factories\StepFactory> */
    use HasFactory;

    public $timestamps = false;

    // Relation : une étape appartient à une recette
    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id');
    }
}

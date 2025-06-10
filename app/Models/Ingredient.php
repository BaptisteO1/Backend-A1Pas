<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    /** @use HasFactory<\Database\Factories\IngredientFactory> */
    use HasFactory;

    public $timestamps = false;

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'ingredient_recipes', 'ingredient_id', 'recipe_id')
                    ->withPivot(['quantity', 'unity']);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    /** @use HasFactory<\Database\Factories\RecipeFactory> */
    use HasFactory;

    public function steps()
    {
        return $this->hasMany(Step::class, 'recipe_id')->orderBy('order') ;
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'ingredient_recipe', 'recipe_id', 'ingredient_id')
                    ->withPivot(['quantity', 'unity']);
    }

    public function addStep(string $description)
    {
        $nextOrder = $this->steps()->max('order') + 1;

        return $this->steps()->create([
            'description' => $description,
            'order' => $nextOrder,
        ]);
    }

}

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

    // Ajout de ce tableau pour forcer l'ajout de l'attribut personnalisé dans le JSON
    protected $appends = ['nutritional_values'];

    // Création d'un Accessor pour "nutritional_values"
    public function getNutritionalValuesAttribute()
    {
        return $this->getTotalNutritionalValues();
    }

    public function getTotalNutritionalValues(): array
    {
        $fields = ['kcal', 'eau', 'lipides', 'ags', 'glucides', 'sucres', 'fibres', 'proteines', 'sel'];
        $totals = [];
        $missing = [];

        // Initialiser les totaux
        foreach ($fields as $field) {
            $totals[$field] = 0;
            $missing[$field] = []; // ici on stock les noms des ingrédients manquants
        }

        foreach ($this->ingredients as $ingredient) {
            
            // Récupérer la quantité et l'unité
            $quantity = $ingredient->pivot->quantity ?? 0;
            $unit = $ingredient->pivot->quantity ?? 'g';

            foreach ($fields as $field) {
                $value = $ingredient->$field;

                if (is_null($value)) {
                    // Ajout du nom de l'ingrédient à la liste des manquants pour ce champ
                    $missing[$field][] = $ingredient->name; 
                    continue;
                }

                // Calcul selon la proportion en grammes / 100g
                $totals[$field] += ($value * $quantity) / 100;
            }
        }

        // Astérisque + liste des ingrédients manquants
        $result = [];
        foreach ($totals as $field => $value) {
            $formattedValue = round($value, 2);
            if (!empty($missing[$field])) {
                $result[$field] = $formattedValue . '* (manquant pour: ' . implode(', ', $missing[$field]) . ')';
            } else {
                $result[$field] = $formattedValue;
            }
        }

        return $result;
    }


}

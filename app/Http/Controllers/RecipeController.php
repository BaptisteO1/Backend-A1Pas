<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    // GET /api/recipes
    public function index()
    {
        // Laravel inclura automatiquement nutritional_values via l'accessor
        return Recipe::with(['steps', 'ingredients'])->get();
    }

    // GET /api/recipes/{id}
    public function show($id)
    {
        // Laravel inclura automatiquement nutritional_values via l'accessor
        return Recipe::with(['steps', 'ingredients'])->findOrFail($id);
    }
}


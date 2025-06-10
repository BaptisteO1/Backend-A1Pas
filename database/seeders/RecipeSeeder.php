<?php

namespace Database\Seeders;

use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\Step;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
     public function run(): void
    {

     // Fonction helper pour créer ingrédients uniques
    function getIngredient($name) {
        return Ingredient::firstOrCreate(['name' => $name]);
    }

     // ----- Salade César -----
    $cesar = Recipe::factory()->create([
        'title' => 'Salade César',
        'preparation_time' => 20,
        'cooking_time' => 12,
        'difficulty' => 'très facile',
        'cost' => 'bon marché',
        'calories' => 999,
    ]);

    $cesarIngredients = [
        ['name' => 'huile', 'quantity' => 2, 'unity' => 'c. à s.'],
        ['name' => 'laitue', 'quantity' => 2, 'unity' => 'cœurs'],
        ['name' => 'Parmesan (copeaux)', 'quantity' => 25, 'unity' => 'g'],
        ['name' => 'pain', 'quantity' => 4, 'unity' => 'tranches'],
        ['name' => 'moutarde', 'quantity' => 1, 'unity' => 'c. à c.'], // "½" remplacé par 1
        ['name' => 'tabasco', 'quantity' => 1, 'unity' => 'trait'],
        ['name' => 'huile (pour la sauce)', 'quantity' => 15, 'unity' => 'cl'],
        ['name' => 'poivre', 'quantity' => 1, 'unity' => 'pincée'], // "au goût" → approximation
        ['name' => 'sel', 'quantity' => 1, 'unity' => 'pincée'],
        ['name' => 'œuf', 'quantity' => 1, 'unity' => ''],
        ['name' => 'parmesan râpé', 'quantity' => 25, 'unity' => 'g'],
        ['name' => 'câpres', 'quantity' => 2, 'unity' => 'c. à c.'],
        ['name' => 'citron', 'quantity' => 1, 'unity' => ''],
        ['name' => 'ail', 'quantity' => 1, 'unity' => 'gousse'], // "1 gousse pelée" → "1 gousse"
    ];


    foreach ($cesarIngredients as $ing) {
        $ingredient = getIngredient($ing['name']);
        $cesar->ingredients()->attach($ingredient->id, ['quantity' => $ing['quantity'], 'unity' => $ing['unity']]);
    }

     $cesarSteps = [
        "Faites dorer le pain, coupé en cubes, 3 min dans un peu d'huile.",
        "Déchirez les feuilles de romaine dans un saladier, et ajoutez les croûtons préalablement épongés.",
        "Préparez la sauce : Faites cuire l'œuf 1 min 30 dans l'eau bouillante, et rafraîchissez-le.",
        "Cassez-le dans le bol d'un mixeur et mixez avec tous les autres ingrédients. Rectifiez l'assaisonnement.",
        "Incorporez à la salade, décorez de copeaux de parmesan, et servez.",
    ];

    foreach ($cesarSteps as $index => $step) {
        Step::create([
            'recipe_id' => $cesar->id,
            'order' => $index + 1,
            'description' => $step,
        ]);
    }

    ////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////

    // ----- Semoule, falafel & tzatziki -----
    $falafel = Recipe::factory()->create([
        'title' => 'Semoule, falafel & tzatziki',
        'preparation_time' => 4,
        'cooking_time' => 12,
        'difficulty' => 'facile',
        'cost' => 'bon marché',
        'calories' => 679,
    ]);

    $falafelIngredients = [
        ['name' => 'semoule', 'quantity' => 60, 'unity' => 'g'],
        ['name' => 'falafel (frais)', 'quantity' => 5, 'unity' => ''],
        ['name' => 'tzatziki', 'quantity' => 60, 'unity' => 'g'],
        ['name' => 'concombre', 'quantity' => 100, 'unity' => 'g'],
        ['name' => 'persil (frais)', 'quantity' => 1, 'unity' => '/10 bouquet'], // facultatif
        ['name' => 'huile d\'olive', 'quantity' => 1, 'unity' => 'c. à s.'],
    ];

    foreach ($falafelIngredients as $ing) {
        $ingredient = getIngredient($ing['name']);
        $falafel->ingredients()->attach($ingredient->id, ['quantity' => $ing['quantity'], 'unity' => $ing['unity']]);
    }

    $falafelSteps = [
        "Faites chauffer une poêle avec un filet d'huile d'olive. Ajoutez les falafels et faites-les griller sur chaque face (les 4) pendant 3 minutes.",
        "Pendant ce temps, lavez et coupez le concombre en cubes.",
        "Faites bouillir de l'eau chaude. Dans un bol, mélangez la semoule avec du sel, du poivre et un filet d'huile d'olive. Versez ensuite par-dessus le même volume de semoule en eau, couvrez et laissez gonfler 5 minutes. Mélangez bien ensuite.",
        "Vérifiez que les falafels soient bien grillés partout puis retirez du feu.",
        "Dans une assiette, servez la semoule avec le concombre, les falafels et le tzatziki (pour une sauce plus onctueuse, mélangez le tzatziki avec une càc. d'eau /pers). Parsemez de persil et d'un bon filet d'huile d'olive, c'est prêt !",
    ];

    foreach ($falafelSteps as $index => $step) {
        Step::create([
            'recipe_id' => $falafel->id,
            'order' => $index + 1,
            'description' => $step,
        ]);
    }

    ////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////

    // ----- Wrap végé avocat & concombre -----
    $wrap = Recipe::factory()->create([
        'title' => 'Wrap végé avocat & concombre',
        'preparation_time' => 5,
        'difficulty' => 'très facile',
        'cost' => 'bon marché',
        'calories' => 519,
    ]);

    $wrapIngredients = [
        ['name' => 'avocat', 'quantity' => 0.5, 'unity' => ''],
        ['name' => 'tortilla (blé)', 'quantity' => 1, 'unity' => ''],
        ['name' => 'fromage frais', 'quantity' => 30, 'unity' => 'g'],
        ['name' => 'concombre', 'quantity' => 0.2, 'unity' => ''], // 1/5 ≈ 0.2
        ['name' => 'pignons de pin', 'quantity' => 1, 'unity' => 'c. à s.'], // facultatif
        ['name' => 'épinard (frais)', 'quantity' => 0.5, 'unity' => 'poignée'],
    ];

    foreach ($wrapIngredients as $ing) {
        $ingredient = getIngredient($ing['name']);
        $wrap->ingredients()->attach($ingredient->id, ['quantity' => $ing['quantity'], 'unity' => $ing['unity']]);
    }

    $wrapSteps = [
        "Coupez l'avocat en 2, retirez le noyau, puis tranchez-le en fines lamelles.",
        "Coupez le concombre en tranches.",
        "Étalez le fromage frais sur la galette de blé.",
        "Ajoutez les pousses d'épinard, l'avocat, le concombre, et (optionnel) quelques pignons si vous en avez.",
        "Salez, poivrez et roulez le tout. C'est prêt !",
    ];

    foreach ($wrapSteps as $index => $step) {
        Step::create([
            'recipe_id' => $wrap->id,
            'order' => $index + 1,
            'description' => $step,
        ]);
    }

    ////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////

    // ----- Bowl rillettes de thon, œuf & concombre -----
    $bowl = Recipe::factory()->create([
        'title' => 'Bowl rillettes de thon, œuf & concombre',
        'preparation_time' => 4,
        'cooking_time' => 6,
        'difficulty' => 'facile',
        'cost' => 'bon marché',
        'calories' => 430,
    ]);

    $bowlIngredients = [
        ['name' => 'mélange céréales (cuites)', 'quantity' => 70, 'unity' => 'g'],
        ['name' => 'œuf', 'quantity' => 1, 'unity' => ''],
        ['name' => 'thon au naturel', 'quantity' => 40, 'unity' => 'g'],
        ['name' => 'skyr', 'quantity' => 20, 'unity' => 'g'],
        ['name' => 'concombre', 'quantity' => 0.25, 'unity' => ''], // 1/4
        ['name' => 'paprika fumé', 'quantity' => 1, 'unity' => 'pincée'],
        ['name' => 'ciboulette', 'quantity' => 1, 'unity' => '/10 bouquet'], // facultatif
    ];

    foreach ($bowlIngredients as $ing) {
        $ingredient = getIngredient($ing['name']);
        $bowl->ingredients()->attach($ingredient->id, ['quantity' => $ing['quantity'], 'unity' => $ing['unity']]);
    }

    $bowlSteps = [
        "Faites cuire les œufs pendant 6 minutes dans une casserole d'eau bouillante. Une fois cuits, plongez-les dans de l'eau froide pour stopper la cuisson. Enlevez la coquille délicatement. Réservez.",
        "Pendant ce temps, lavez puis coupez le concombre en dés.",
        "Réchauffez le mélange de céréales selon les instructions du paquet.",
        "Préparez les rillettes de thon. Dans un bol, mélangez : le thon préalablement égoutté, le skyr, le paprika fumé et la ciboulette ciselée (optionnel). Salez, poivrez et ajoutez un filet d'huile d'olive.",
        "Dans un bol ou une assiette creuse, servez le mélange de céréales avec le concombre, l'œuf mollet coupé en deux et les rillettes de thon. Ajoutez un filet d'huile d'olive, une pincée de paprika fumé et un peu de ciboulette ciselée, s'il vous en reste. C'est prêt!",
    ];

    foreach ($bowlSteps as $index => $step) {
        Step::create([
            'recipe_id' => $bowl->id,
            'order' => $index + 1,
            'description' => $step,
        ]);
    }


    }

}

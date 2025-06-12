<?php
//php artisan ingredients:update-from-calnut

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Storage;

class UpdateIngredientsFromCalnut extends Command
{
    protected $signature = 'ingredients:update-from-calnut';
    protected $description = 'Met à jour les ingrédients avec les valeurs du fichier Calnut';

    // Correspondance entre code calnut et champs
    protected $nutrientsMap = [
        '333' => 'kcal',
        '400' => 'eau',
        '40000' => 'lipides',
        '40302' => 'ags',
        '31000' => 'glucides',
        '32000' => 'sucres',
        '34100' => 'fibres',
        '25000' => 'proteines',
        '10004' => 'sel',
    ];

    protected function nettoyerNom($nom) {
        $nom = mb_strtolower($nom, 'UTF-8');           // minuscule en UTF-8, garde les accents
        
        // Cas spécial pour "graine de couscous..."
        if (str_contains($nom, 'graine de couscous')) {
            return 'semoule';
        }

        $nom = preg_replace('/,.*/u', '', $nom); // Supprimer tout ce qui est après la première virgule (y compris la virgule)
        $nom = preg_replace('/[^\p{L}\p{N} ]+/u', '', $nom); // enlève la ponctuation (tout sauf lettres, chiffres et espaces)
        $nom = preg_replace('/\s+/', ' ', $nom);       // espaces multiples → un seul espace
        
        // retirer certains mots inutiles
        $stopWords = ['cru', 'crue', 'cuit', 'cuite', 'frais', 'fraîche', 'fraîches', 'fraîs', 'râpé', 'copeaux', 'pour la sauce', 'vierge extra']; 
        foreach ($stopWords as $stopWord) {
            // retirer mots entiers uniquement (avec espaces ou début/fin)
            $nom = preg_replace('/\b' . preg_quote($stopWord, '/') . '\b/u', '', $nom);
        }

        $nom = preg_replace('/\s+/', ' ', $nom); // nettoyage espaces éventuels restants
        return trim($nom);
    }

    public function handle()
    {
        $csvPath = storage_path('app/CALNUT2020nettoye.csv');

        if (!file_exists($csvPath)) {
            $this->error("Fichier CSV non trouvé : $csvPath");
            return;
        }

        $handle = fopen($csvPath, 'r');
        if (!$handle) {
            $this->error("Impossible d'ouvrir le fichier");
            return;
        }

        $calnutData = [];

        while (($line = fgetcsv($handle, 0, ';')) !== false) {
            $nom = trim($line[1]);
            $codeNutriment = trim($line[6]);
            $valeur = floatval(str_replace(',', '.', $line[3]));

            if (array_key_exists($codeNutriment, $this->nutrientsMap)) {
                $champ = $this->nutrientsMap[$codeNutriment];
                $calnutData[$nom][$champ] = $valeur;
            }
        }

        fclose($handle);

        $ingredients = Ingredient::all();

        foreach ($ingredients as $ingredient) {
            $matchFound = false;
            foreach ($calnutData as $nomCalnut => $values) {
                $cleanIngredientName = $this->nettoyerNom($ingredient->name);
                $cleanCalnutName = $this->nettoyerNom($nomCalnut);
                similar_text($cleanIngredientName, $cleanCalnutName, $percent);
        
                // $this->line("Comparaison: '{$cleanIngredientName}' vs '{$cleanCalnutName}' => $percent%");

                if ($percent > 85) { // seuil de similarité
                    $ingredient->fill($values)->save();
                    $this->info("✅ Mis à jour : {$ingredient->name} ← {$nomCalnut}");
                    $matchFound = true;
                    break;
                }
            }

            if (!$matchFound) {
                $this->warn("❌ Pas trouvé : {$ingredient->name}");
            }
        }

        $this->info("Mise à jour terminée.");
    }
}

<?php
// php artisan ingredients:clean-csv storage/app/public/CALNUT2020.csv storage/app/CALNUT2020nettoye.csv
namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanCalnutCsv extends Command
{
    protected $signature = 'ingredients:clean-csv 
                            {input : Le chemin vers le fichier CSV d\'entrée}
                            {output : Le chemin du fichier CSV nettoyé}';

    protected $description = 'Nettoie le fichier CSV en supprimant les lignes avec un Code CALNUT non autorisé.';

    protected array $codesAutorises = [
        '333', '400', '40000', '40302',
        '31000', '32000', '34100', '25000', '10004'
    ];

    public function handle()
    {
        $inputFile = $this->argument('input');
        $outputFile = $this->argument('output');

        if (!file_exists($inputFile)) {
            $this->error("Fichier d'entrée non trouvé : $inputFile");
            return Command::FAILURE;
        }

        $in = fopen($inputFile, 'r');
        $out = fopen($outputFile, 'w');

        if (!$in || !$out) {
            $this->error("Impossible d'ouvrir les fichiers.");
            return Command::FAILURE;
        }

        $header = fgetcsv($in, 0, ';');
        fputcsv($out, $header, ';');

        $filtered = 0;
        $kept = 0;

        while (($line = fgetcsv($in, 0, ';')) !== false) {
            $code = trim($line[6]);
            if (in_array($code, $this->codesAutorises)) {
                fputcsv($out, $line, ';');
                $kept++;
            } else {
                $filtered++;
            }
        }

        fclose($in);
        fclose($out);

        $this->info("Nettoyage terminé. Lignes gardées : $kept, lignes supprimées : $filtered");
        $this->info("Fichier nettoyé : $outputFile");

        return Command::SUCCESS;
    }
}

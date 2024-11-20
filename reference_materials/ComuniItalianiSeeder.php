<?php

namespace Database\Seeders;

use App\Models\Comune;
use App\Models\Provincia;
use App\Models\Regione;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use League\Csv\Reader;

class ComuniItalianiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Scarica il file CSV
        $csvFile = Http::get('https://www.istat.it/storage/codici-unita-amministrative/Elenco-comuni-italiani.csv')->body();

        $csv = Reader::createFromString($csvFile);
        $csv->setOutputBOM(Reader::BOM_UTF8);
        $csv->addStreamFilter('convert.iconv.ISO-8859-15/UTF-8');
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0); //set the CSV header offset
        $records = $csv->getRecords();

        // count csv rows
        echo ('Comuni csv da importare ' . $csv->count() . ' ');

        $i = 0;
        foreach ($records as $record) {
            //do something here
            // dump($record);
            $values = array_values($record);
            //   dump($values);
            //  break;
            //  return;
            // Importa dati nella tabella "regioni"
            $regione = Regione::firstOrCreate([
                'ripartizione_geografica' => $values[9],
                'nome_regione' => $values[10],
            ]);

            // Importa dati nella tabella "province"
            $provincia = Provincia::firstOrCreate([
                'nome_provincia' => $values[11],
                'sigla' => $values[14],
                'regione_id' => $regione->id,
            ]);

            // Importa dati nella tabella "comuni"
            $comune = Comune::firstOrCreate([
                'nome_comune' => $values[5],
                'codice_catastale' => $values[19],
                'provincia_id' => $provincia->id,
            ]);

            $i++;

        }
        echo ('totale comuni salvati su db ' . $i);

    }
}

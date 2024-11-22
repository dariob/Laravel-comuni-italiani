<?php

namespace DarioBarila\ComuniItaliani\Commands;

use Illuminate\Console\Command;
use League\Csv\Reader;
use DarioBarila\ComuniItaliani\Models\Regione;
use DarioBarila\ComuniItaliani\Models\Provincia;
use DarioBarila\ComuniItaliani\Models\Comune;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class ImportaComuniCommand extends Command
{
    protected $signature = 'comuni-italiani:importa';
    protected $description = 'Importa i dati dei comuni italiani dal sito ISTAT';

    public function handle()
    {
        $this->info('Scaricamento dati ISTAT in corso...');

        try {
            // Scarica il file CSV
            $response = Http::get(config('comuni-italiani.istat_url'));
            if (!$response->successful()) {
                throw new \Exception('Impossibile scaricare il file CSV dal sito ISTAT');
            }

            // Crea un reader CSV temporaneo
            $csvContent = $response->body();
            $tempFile = tempnam(sys_get_temp_dir(), 'comuni');
            file_put_contents($tempFile, $csvContent);

            $csv = Reader::createFromPath($tempFile, 'r');
            $csv->setOutputBOM(Reader::BOM_UTF8);
            $csv->addStreamFilter('convert.iconv.ISO-8859-15/UTF-8');
            $csv->setDelimiter(';');
            $csv->setHeaderOffset(0);

            DB::beginTransaction();

            // Svuota le tabelle nell'ordine corretto per rispettare le foreign key
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Comune::truncate();
            Provincia::truncate();
            Regione::truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            $records = $csv->getRecords();
            $regioni = [];
            $province = [];
            $count = 0;

            foreach ($records as $record) {
                $values = array_values($record);

                // Gestione Regione
                $nomeRegione = $values[10];
                if (!isset($regioni[$nomeRegione])) {
                    $regione = Regione::create([
                        'nome' => $nomeRegione,
                        'codice_istat' => $values[0],
                    ]);
                    $regioni[$nomeRegione] = $regione->id;
                }

                // Gestione Provincia
                $nomeProvincia = $values[11];
                $chiaveProvincia = $nomeProvincia . '-' . $values[14]; // nome + sigla
                if (!isset($province[$chiaveProvincia])) {
                    $provincia = Provincia::create([
                        'nome' => $nomeProvincia,
                        'codice_istat' => $values[2],
                        'sigla' => $values[14],
                        'regione_id' => $regioni[$nomeRegione],
                    ]);
                    $province[$chiaveProvincia] = $provincia->id;
                }

                // Gestione Comune
                Comune::create([
                    'nome' => $values[5],
                    'codice_istat' => $values[4],
                    'codice_catastale' => $values[19],
                    'provincia_id' => $province[$chiaveProvincia],
                ]);

                $count++;
            }

            DB::commit();
            unlink($tempFile);

            $this->info("Importazione completata con successo! Importati $count comuni.");
            
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($tempFile) && file_exists($tempFile)) {
                unlink($tempFile);
            }
            $this->error('Errore durante l\'importazione: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}

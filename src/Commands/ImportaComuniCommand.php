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
            $csv->setHeaderOffset(0);
            $csv->setDelimiter(';');

            DB::beginTransaction();

            // Svuota le tabelle
            Comune::truncate();
            Provincia::truncate();
            Regione::truncate();

            $records = $csv->getRecords();
            $regioni = [];
            $province = [];

            foreach ($records as $record) {
                // Gestione Regione
                $codiceRegione = $record['Codice Regione'];
                if (!isset($regioni[$codiceRegione])) {
                    $regione = Regione::create([
                        'nome' => $record['Denominazione Regione'],
                        'codice_istat' => $codiceRegione,
                    ]);
                    $regioni[$codiceRegione] = $regione->id;
                }

                // Gestione Provincia
                $codiceProvincia = $record['Codice Provincia (Storico)(1)'];
                if (!isset($province[$codiceProvincia])) {
                    $provincia = Provincia::create([
                        'nome' => $record['Denominazione dell\'Unità territoriale sovracomunale (valida a fini statistici)'],
                        'codice_istat' => $codiceProvincia,
                        'sigla' => $record['Sigla automobilistica'],
                        'regione_id' => $regioni[$codiceRegione],
                    ]);
                    $province[$codiceProvincia] = $provincia->id;
                }

                // Gestione Comune
                Comune::create([
                    'nome' => $record['Denominazione in italiano'],
                    'codice_istat' => $record['Codice Comune formato numerico'],
                    'codice_catastale' => $record['Codice Catastale del comune'],
                    'provincia_id' => $province[$codiceProvincia],
                ]);
            }

            DB::commit();
            unlink($tempFile);

            $this->info('Importazione completata con successo!');
            
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

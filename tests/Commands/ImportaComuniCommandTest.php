<?php

use DarioBarila\ComuniItaliani\Models\Regione;
use DarioBarila\ComuniItaliani\Models\Provincia;
use DarioBarila\ComuniItaliani\Models\Comune;
use Illuminate\Support\Facades\Http;

test('il comando importa correttamente i dati dal CSV', function () {
    // Mock della risposta HTTP
    Http::fake([
        config('comuni-italiani.istat_url') => Http::response(
            file_get_contents(__DIR__ . '/../stubs/comuni.csv'),
            200
        ),
    ]);

    // Esegue il comando
    $this->artisan('comuni-italiani:importa')->assertSuccessful();

    // Verifica che i dati siano stati importati
    expect(Regione::count())->toBeGreaterThan(0)
        ->and(Provincia::count())->toBeGreaterThan(0)
        ->and(Comune::count())->toBeGreaterThan(0);
});

test('il comando gestisce correttamente gli errori di download', function () {
    // Mock della risposta HTTP con errore
    Http::fake([
        config('comuni-italiani.istat_url') => Http::response(null, 404),
    ]);

    // Esegue il comando e verifica che fallisca
    $this->artisan('comuni-italiani:importa')->assertFailed();

    // Verifica che non ci siano dati nel database
    expect(Regione::count())->toBe(0)
        ->and(Provincia::count())->toBe(0)
        ->and(Comune::count())->toBe(0);
});

<?php

use DarioBarila\ComuniItaliani\Models\Regione;
use DarioBarila\ComuniItaliani\Models\Provincia;

test('una regione può avere più province', function () {
    $regione = Regione::factory()
        ->has(Provincia::factory()->count(3))
        ->create();

    expect($regione->province)->toHaveCount(3)
        ->and($regione->province->first())->toBeInstanceOf(Provincia::class);
});

test('una regione ha i campi corretti', function () {
    $regione = Regione::factory()->create([
        'nome' => 'Lombardia',
        'codice_istat' => '03',
    ]);

    expect($regione->nome)->toBe('Lombardia')
        ->and($regione->codice_istat)->toBe('03');
});

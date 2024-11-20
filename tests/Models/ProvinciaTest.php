<?php

use DarioBarila\ComuniItaliani\Models\Provincia;
use DarioBarila\ComuniItaliani\Models\Regione;
use DarioBarila\ComuniItaliani\Models\Comune;

test('una provincia appartiene a una regione', function () {
    $provincia = Provincia::factory()
        ->for(Regione::factory())
        ->create();

    expect($provincia->regione)->toBeInstanceOf(Regione::class);
});

test('una provincia può avere più comuni', function () {
    $provincia = Provincia::factory()
        ->has(Comune::factory()->count(3))
        ->create();

    expect($provincia->comuni)->toHaveCount(3)
        ->and($provincia->comuni->first())->toBeInstanceOf(Comune::class);
});

test('una provincia ha i campi corretti', function () {
    $provincia = Provincia::factory()->create([
        'nome' => 'Milano',
        'codice_istat' => '015',
        'sigla' => 'MI',
    ]);

    expect($provincia->nome)->toBe('Milano')
        ->and($provincia->codice_istat)->toBe('015')
        ->and($provincia->sigla)->toBe('MI');
});

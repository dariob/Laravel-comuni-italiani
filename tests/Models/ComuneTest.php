<?php

use DarioBarila\ComuniItaliani\Models\Comune;
use DarioBarila\ComuniItaliani\Models\Provincia;

test('un comune appartiene a una provincia', function () {
    $comune = Comune::factory()
        ->for(Provincia::factory())
        ->create();

    expect($comune->provincia)->toBeInstanceOf(Provincia::class);
});

test('un comune ha i campi corretti', function () {
    $comune = Comune::factory()->create([
        'nome' => 'Milano',
        'codice_istat' => '015146',
        'codice_catastale' => 'F205',
    ]);

    expect($comune->nome)->toBe('Milano')
        ->and($comune->codice_istat)->toBe('015146')
        ->and($comune->codice_catastale)->toBe('F205');
});

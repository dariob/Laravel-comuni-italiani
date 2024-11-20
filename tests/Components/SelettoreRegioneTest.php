<?php

use DarioBarila\ComuniItaliani\Models\Regione;
use DarioBarila\ComuniItaliani\Components\SelettoreRegione;
use Livewire\Livewire;

test('il componente selettore regione può essere montato', function () {
    Livewire::test(SelettoreRegione::class)
        ->assertOk();
});

test('il componente mostra le regioni ordinate per nome', function () {
    // Crea alcune regioni in ordine casuale
    Regione::factory()->create(['nome' => 'Veneto']);
    Regione::factory()->create(['nome' => 'Lombardia']);
    Regione::factory()->create(['nome' => 'Abruzzo']);

    $component = Livewire::test(SelettoreRegione::class);
    
    // Verifica che le regioni siano ordinate alfabeticamente
    $regioni = $component->viewData('regioni');
    $nomi = $regioni->pluck('nome')->toArray();
    
    expect($nomi)->toBe(['Abruzzo', 'Lombardia', 'Veneto']);
});

test('il componente emette un evento quando viene selezionata una regione', function () {
    $regione = Regione::factory()->create();

    Livewire::test(SelettoreRegione::class)
        ->set('selectedRegione', $regione->id)
        ->assertDispatched('regione-selected', regione: $regione->id);
});

<?php

use DarioBarila\ComuniItaliani\Models\Provincia;
use DarioBarila\ComuniItaliani\Models\Comune;
use DarioBarila\ComuniItaliani\Components\SelettoreComune;
use Livewire\Livewire;

test('il componente selettore comune può essere montato', function () {
    Livewire::test(SelettoreComune::class)
        ->assertOk();
});

test('il componente mostra i comuni della provincia selezionata', function () {
    $provincia = Provincia::factory()->create();
    $comuni = Comune::factory()->count(3)->create(['provincia_id' => $provincia->id]);
    $altroComune = Comune::factory()->create(); // Comune di un'altra provincia

    $component = Livewire::test(SelettoreComune::class)
        ->set('provinciaId', $provincia->id);

    $comuniComponent = $component->viewData('comuni');
    
    // Verifica che vengano mostrati solo i comuni della provincia selezionata
    expect($comuniComponent)->toHaveCount(3)
        ->and($comuniComponent->pluck('id'))->not->toContain($altroComune->id);
});

test('il componente emette un evento quando viene selezionato un comune', function () {
    $comune = Comune::factory()->create();

    Livewire::test(SelettoreComune::class)
        ->set('provinciaId', $comune->provincia_id)
        ->set('selectedComune', $comune->id)
        ->assertDispatched('comune-selected', comune: $comune->id);
});

test('il componente resetta il comune selezionato quando cambia la provincia', function () {
    $comune = Comune::factory()->create();
    
    $component = Livewire::test(SelettoreComune::class)
        ->set('selectedComune', $comune->id)
        ->set('provinciaId', Provincia::factory()->create()->id);

    expect($component->get('selectedComune'))->toBeNull();
});

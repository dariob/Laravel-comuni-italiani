<?php

use DarioBarila\ComuniItaliani\Models\Regione;
use DarioBarila\ComuniItaliani\Models\Provincia;
use DarioBarila\ComuniItaliani\Components\SelettoreProvincia;
use Livewire\Livewire;

test('il componente selettore provincia può essere montato', function () {
    Livewire::test(SelettoreProvincia::class)
        ->assertOk();
});

test('il componente mostra le province della regione selezionata', function () {
    $regione = Regione::factory()->create();
    $province = Provincia::factory()->count(3)->create(['regione_id' => $regione->id]);
    $altraProvincia = Provincia::factory()->create(); // Provincia di un'altra regione

    $component = Livewire::test(SelettoreProvincia::class)
        ->set('regioneId', $regione->id);

    $provinceComponent = $component->viewData('province');
    
    // Verifica che vengano mostrate solo le province della regione selezionata
    expect($provinceComponent)->toHaveCount(3)
        ->and($provinceComponent->pluck('id'))->not->toContain($altraProvincia->id);
});

test('il componente emette un evento quando viene selezionata una provincia', function () {
    $provincia = Provincia::factory()->create();

    Livewire::test(SelettoreProvincia::class)
        ->set('regioneId', $provincia->regione_id)
        ->set('selectedProvincia', $provincia->id)
        ->assertDispatched('provincia-selected', provincia: $provincia->id);
});

test('il componente resetta la provincia selezionata quando cambia la regione', function () {
    $provincia = Provincia::factory()->create();
    
    $component = Livewire::test(SelettoreProvincia::class)
        ->set('selectedProvincia', $provincia->id)
        ->set('regioneId', Regione::factory()->create()->id);

    expect($component->get('selectedProvincia'))->toBeNull();
});

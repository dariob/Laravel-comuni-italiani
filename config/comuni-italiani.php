<?php

return [
    /*
    |--------------------------------------------------------------------------
    | ISTAT Data Source URL
    |--------------------------------------------------------------------------
    |
    | URL per scaricare i dati aggiornati dei comuni italiani dal sito ISTAT.
    |
    */
    'istat_url' => env('COMUNI_ITALIANI_ISTAT_URL', 'https://www.istat.it/storage/codici-unita-amministrative/Elenco-comuni-italiani.csv'),

    /*
    |--------------------------------------------------------------------------
    | Cache Duration
    |--------------------------------------------------------------------------
    |
    | Durata della cache per i dati dei comuni in minuti.
    |
    */
    'cache_duration' => env('COMUNI_ITALIANI_CACHE_DURATION', 60 * 24), // 24 ore

    /*
    |--------------------------------------------------------------------------
    | Component Classes
    |--------------------------------------------------------------------------
    |
    | Classi CSS personalizzabili per i componenti Livewire.
    |
    */
    'component_classes' => [
        'select' => 'form-select',
        'label' => 'form-label',
        'wrapper' => 'mb-3',
    ],
];

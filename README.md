# Comuni Italiani per Laravel

Package Laravel per la selezione di regioni, province e comuni italiani utilizzando componenti Livewire.

## Installazione

```bash
composer require dariobarila/comuni-italiani
```

## Configurazione

1. Pubblica le migrazioni:
```bash
php artisan vendor:publish --tag=comuni-italiani-migrations
```

2. Pubblica il file di configurazione (opzionale):
```bash
php artisan vendor:publish --tag=comuni-italiani-config
```

3. Esegui le migrazioni:
```bash
php artisan migrate
```

4. Importa i dati dei comuni:
```bash
php artisan comuni-italiani:importa
```

## Utilizzo

### Componenti Livewire

Il package fornisce tre componenti Livewire che si aggiornano automaticamente in cascata:

1. Selettore Regione:
```html
<livewire:selettore-regione />
```

2. Selettore Provincia (si aggiorna quando cambia la regione):
```html
<livewire:selettore-provincia />
```

3. Selettore Comune (si aggiorna quando cambia la provincia):
```html
<livewire:selettore-comune />
```

### Esempio di Utilizzo Completo

```php
<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class SelezioneComuni extends Component
{
    public $datiRegione = [];
    public $datiProvincia = [];
    public $datiComune = [];

    #[On('comuni-italiani::selezione-completa')]
    public function selezioneDatiCompleta($data)
    {
        $this->datiRegione = $data['regione'];
        $this->datiProvincia = $data['provincia'];
        $this->datiComune = $data['comune'];
    }

    public function render()
    {
        return view('livewire.selezione-comuni');
    }
}
```

```html
<div>
    <form>
        <livewire:selettore-regione />
        <livewire:selettore-provincia />
        <livewire:selettore-comune />
    </form>

    @if(!empty($datiComune))
        <h3>Selezione completa:</h3>
        <ul>
            <li>Regione: {{ $datiRegione['nome'] }}</li>
            <li>Provincia: {{ $datiProvincia['nome'] }} ({{ $datiProvincia['sigla'] }})</li>
            <li>Comune: {{ $datiComune['nome'] }}</li>
        </ul>
    @endif
</div>
```

### Eventi Livewire

Quando viene completata una selezione (cioè quando viene selezionato un comune), il package emette l'evento `comuni-italiani::selezione-completa` con tutti i dati della selezione:

```php
[
    'regione' => [
        'id' => 3,
        'nome' => 'Lombardia',
        'codice_istat' => '03',
    ],
    'provincia' => [
        'id' => 15,
        'nome' => 'Milano',
        'sigla' => 'MI',
        'codice_istat' => '015',
    ],
    'comune' => [
        'id' => 15146,
        'nome' => 'Milano',
        'codice_istat' => '015146',
        'codice_catastale' => 'F205',
    ],
]
```

### Utilizzo in Form HTML

I componenti possono essere utilizzati anche in form HTML tradizionali. Ogni select ha un attributo `name` corrispondente (`regione`, `provincia`, `comune`):

```html
<form method="POST" action="/salva-comune">
    @csrf
    <livewire:selettore-regione />
    <livewire:selettore-provincia />
    <livewire:selettore-comune />
    <button type="submit">Salva</button>
</form>
```

### Personalizzazione dello Stile

È possibile personalizzare le classi CSS dei componenti modificando il file di configurazione `config/comuni-italiani.php`:

```php
return [
    'component_classes' => [
        'select' => 'form-select',
        'label' => 'form-label',
        'wrapper' => 'mb-3',
    ],
];
```

## Aggiornamento dei Dati

Per aggiornare i dati dei comuni con quelli più recenti dal sito ISTAT, esegui:

```bash
php artisan comuni-italiani:importa
```

## Licenza

Il package è rilasciato sotto licenza MIT. Vedere il file [LICENSE](LICENSE.md) per maggiori dettagli.

## Autore

- Dario Barilà
- Email: dario.barila@gmail.com

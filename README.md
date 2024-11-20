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

Il package fornisce tre componenti Livewire:

1. Selettore Regione:
```html
<livewire:selettore-regione />
```

2. Selettore Provincia:
```html
<livewire:selettore-provincia />
```

3. Selettore Comune:
```html
<livewire:selettore-comune />
```

### Esempio di Utilizzo Completo

```html
<form>
    <livewire:selettore-regione />
    <livewire:selettore-provincia />
    <livewire:selettore-comune />
</form>
```

### Eventi Livewire

I componenti emettono i seguenti eventi quando viene selezionato un valore:

- `regione-selected`: Emesso quando viene selezionata una regione
- `provincia-selected`: Emesso quando viene selezionata una provincia
- `comune-selected`: Emesso quando viene selezionato un comune

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

<?php

namespace DarioBarila\ComuniItaliani\Database\Factories;

use DarioBarila\ComuniItaliani\Models\Provincia;
use DarioBarila\ComuniItaliani\Models\Regione;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProvinciaFactory extends Factory
{
    protected $model = Provincia::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->unique()->city() . ' Province',
            'codice_istat' => $this->faker->unique()->numberBetween(1, 110),
            'sigla' => strtoupper($this->faker->unique()->lexify('??')),
            'regione_id' => Regione::factory(),
        ];
    }
}

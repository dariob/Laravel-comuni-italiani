<?php

namespace DarioBarila\ComuniItaliani\Database\Factories;

use DarioBarila\ComuniItaliani\Models\Comune;
use DarioBarila\ComuniItaliani\Models\Provincia;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComuneFactory extends Factory
{
    protected $model = Comune::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->unique()->city(),
            'codice_istat' => $this->faker->unique()->numberBetween(1, 8000),
            'codice_catastale' => strtoupper($this->faker->unique()->lexify('????')),
            'provincia_id' => Provincia::factory(),
        ];
    }
}

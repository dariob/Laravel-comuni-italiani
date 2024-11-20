<?php

namespace DarioBarila\ComuniItaliani\Database\Factories;

use DarioBarila\ComuniItaliani\Models\Regione;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegioneFactory extends Factory
{
    protected $model = Regione::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->unique()->region(),
            'codice_istat' => $this->faker->unique()->numberBetween(1, 20),
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regione extends Model
{
    protected $table = 'regioni';

    protected $fillable = ['nome_regione', 'ripartizione_geografica'];

    public function province()
    {
        return $this->hasMany(Provincia::class, 'regione_id');
    }
}

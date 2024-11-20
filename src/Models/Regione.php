<?php

namespace DarioBarila\ComuniItaliani\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Regione extends Model
{
    protected $table = 'regioni';
    
    protected $fillable = [
        'nome',
        'codice_istat',
    ];

    public function province(): HasMany
    {
        return $this->hasMany(Provincia::class);
    }
}

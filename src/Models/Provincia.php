<?php

namespace DarioBarila\ComuniItaliani\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Provincia extends Model
{
    protected $table = 'province';
    
    protected $fillable = [
        'nome',
        'codice_istat',
        'sigla',
        'regione_id',
    ];

    public function regione(): BelongsTo
    {
        return $this->belongsTo(Regione::class);
    }

    public function comuni(): HasMany
    {
        return $this->hasMany(Comune::class);
    }
}

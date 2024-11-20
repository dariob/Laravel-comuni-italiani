<?php

namespace DarioBarila\ComuniItaliani\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comune extends Model
{
    protected $table = 'comuni';
    
    protected $fillable = [
        'nome',
        'codice_istat',
        'codice_catastale',
        'provincia_id',
    ];

    public function provincia(): BelongsTo
    {
        return $this->belongsTo(Provincia::class);
    }
}

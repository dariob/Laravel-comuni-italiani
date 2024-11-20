<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comune extends Model
{
    protected $table = 'comuni';

    protected $fillable = ['nome_comune', 'codice_catastale', 'provincia_id'];
    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'provincia_id');
    }
}

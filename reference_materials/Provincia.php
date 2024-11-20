<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $table = 'province';

    protected $fillable = ['nome_provincia','sigla','regione_id'];

    public function regione()
    {
        return $this->belongsTo(Regione::class, 'regione_id');
    }

    public function comuni()
    {
        return $this->hasMany(Comune::class, 'provincia_id');
    }
}

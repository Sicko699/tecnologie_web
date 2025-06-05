<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    protected $table = 'medici'; // <-- Specifica correttamente il nome della tabella

    protected $fillable = [
        'nome',
        'cognome',
        'specializzazione',
    ];

    public function prestazioni()
    {
        return $this->hasMany(Prestazione::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}



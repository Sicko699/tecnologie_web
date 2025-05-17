<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Richiesta extends Model
{
    use HasFactory;

    protected $table = 'richieste';
    public $timestamps = false;

    protected $primaryKey = 'id_richiesta';

    protected $fillable = [
        'id_utente', 'id_prestazione', 'data_richiesta', 'giorno_escluso', 'stato'
    ];

    public function utente()
    {
        return $this->belongsTo(User::class, 'id_utente', 'codice_fiscale');
    }

    public function prestazione()
    {
        return $this->belongsTo(Prestazione::class, 'id_prestazione');
    }

    public function appuntamenti()
    {
        return $this->hasMany(Appuntamento::class, 'id_richiesta');
    }
}

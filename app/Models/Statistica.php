<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistica extends Model
{
    use HasFactory;

    protected $table = 'statistiche';
    protected $primaryKey = 'id_statistica';

    protected $fillable = [
        'id_amministratore', 'id_prestazione', 'data_inizio', 'data_fine', 'tipo', 'risultato'
    ];

    public $timestamps = false;

    public function amministratore()
    {
        return $this->belongsTo(Amministratore::class, 'id_amministratore', 'codice_fiscale');
    }

    public function prestazione()
    {
        return $this->belongsTo(Prestazione::class, 'id_prestazione');
    }
}

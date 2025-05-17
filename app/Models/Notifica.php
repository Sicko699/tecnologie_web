<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifica extends Model
{
    use HasFactory;

    protected $table = 'notifiche';
    public $timestamps = false;

    protected $primaryKey = 'id_notifica';

    protected $fillable = [
        'id_utente', 'messaggio', 'data_creazione', 'conferma_lettura'
    ];

    public function utente()
    {
        return $this->belongsTo(User::class, 'id_utente', 'codice_fiscale');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $table = 'agende';
    public $timestamps = false;
    protected $primaryKey = 'id_agenda';

    protected $fillable = [
        'id_dipartimento',
        'id_prestazione',
        'giorni_settimana', // array di indici giorni
        'orari',            // array associativo giorno => array di orari
        'max_appuntamenti'
    ];

    protected $casts = [
        'giorni_settimana' => 'array',
        'orari' => 'array',
    ];

    public function dipartimento()
    {
        return $this->belongsTo(Dipartimento::class, 'id_dipartimento');
    }

    public function prestazione()
    {
        return $this->belongsTo(Prestazione::class, 'id_prestazione');
    }
}

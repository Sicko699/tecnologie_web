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

    // Nel modello Agenda
    protected $fillable = [
        'id_dipartimento',
        'id_prestazione',
        'configurazione_orari',
        'max_appuntamenti'
    ];

    protected $casts = [
        'configurazione_orari' => 'array'
    ];

// Relazioni
    public function dipartimento()
    {
        return $this->belongsTo(Dipartimento::class, 'id_dipartimento');
    }

    public function prestazione()
    {
        return $this->belongsTo(Prestazione::class, 'id_prestazione');
    }
}

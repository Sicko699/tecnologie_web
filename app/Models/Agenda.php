<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $table = 'agenda';

    public $timestamps = false;

    protected $primaryKey = 'id_agenda';

    protected $fillable = [
        'id_prestazione',   // FK alla prestazione
        'giorno_settimana', // Es: 'Lunedi', 'Martedi', ecc. o numerico 1-7
        'slot_orario',      // Es: '09:00-10:00'
        'max_appuntamenti'
    ];

    public function prestazione()
    {
        return $this->belongsTo(Prestazione::class, 'id_prestazione');
    }
}

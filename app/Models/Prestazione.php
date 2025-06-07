<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestazione extends Model
{
    use HasFactory;

    protected $table = 'prestazioni';
    protected $primaryKey = 'id_prestazione';
    public $timestamps = false;

    protected $fillable = [
        'nome', 'descrizione', 'id_dipartimento'
    ];

    public function dipartimento()
    {
        return $this->belongsTo(Dipartimento::class, 'id_dipartimento', 'id_dipartimento');
    }

    public function richieste()
    {
        return $this->hasMany(Richiesta::class, 'id_prestazione');
    }

    public function membriStaff()
    {
        return $this->belongsToMany(
            MembroStaff::class,
            'membrostaff_prestazione',
            'id_prestazione',
            'codice_fiscale',
            'id_prestazione',
            'codice_fiscale'
        );
    }

    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }

    public function agenda()
    {
        return $this->hasOne(Agenda::class, 'id_prestazione', 'id_prestazione');
    }
}

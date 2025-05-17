<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestazione extends Model
{
    use HasFactory;

    protected $table = 'prestazioni';
    public $timestamps = false;

    protected $primaryKey = 'id_prestazione';

    protected $fillable = [
        'nome', 'descrizione', 'id_dipartimento', 'id_membro'
    ];

    public function dipartimento()
    {
        return $this->belongsTo(Dipartimento::class, 'id_dipartimento');
    }

    public function membroStaff()
    {
        return $this->belongsTo(MembroStaff::class, 'id_membro', 'codice_fiscale');
    }

    public function richieste()
    {
        return $this->hasMany(Richiesta::class, 'id_prestazione');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembroStaff extends Model
{
    use HasFactory;

    protected $table = 'membro_staff';
    public $timestamps = false;

    protected $primaryKey = 'codice_fiscale';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['codice_fiscale', 'id_dipartimento'];

    public function user()
    {
        return $this->belongsTo(User::class, 'codice_fiscale', 'codice_fiscale');
    }

    public function dipartimento()
    {
        return $this->belongsTo(Dipartimento::class, 'id_dipartimento');
    }

    // Relazione molti-a-molti con Prestazione (pivot aggiornata)
    public function prestazioni()
    {
        return $this->belongsToMany(
            Prestazione::class,
            'membrostaff_prestazione',
            'codice_fiscale',     // chiave locale su questa tabella
            'id_prestazione',     // chiave esterna verso Prestazione
            'codice_fiscale',     // local key su questa tabella
            'id_prestazione'      // local key su Prestazione
        );
    }
}

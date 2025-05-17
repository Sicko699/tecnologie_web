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

    public function prestazioni()
    {
        return $this->hasMany(Prestazione::class, 'id_membro', 'codice_fiscale');
    }
}

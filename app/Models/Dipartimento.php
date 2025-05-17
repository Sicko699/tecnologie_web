<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dipartimento extends Model
{
    use HasFactory;

    protected $table = 'dipartimenti';
    public $timestamps = false;

    protected $primaryKey = 'id_dipartimento';

    protected $fillable = ['nome', 'descrizione'];

    public function membroStaff()
    {
        return $this->hasMany(MembroStaff::class, 'id_dipartimento');
    }

    public function prestazioni()
    {
        return $this->hasMany(Prestazione::class, 'id_dipartimento');
    }
}

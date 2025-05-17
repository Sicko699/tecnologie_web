<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amministratore extends Model
{
    use HasFactory;

    protected $table = 'amministratori';
    public $timestamps = false;

    protected $primaryKey = 'codice_fiscale';
    public $incrementing = false;
    protected $keyType = 'string';

    public function user()
    {
        return $this->belongsTo(User::class, 'codice_fiscale', 'codice_fiscale');
    }

    public function statistiche()
    {
        return $this->hasMany(Statistica::class, 'id_amministratore', 'codice_fiscale');
    }
}

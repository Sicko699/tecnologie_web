<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'codice_fiscale';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [
        'codice_fiscale', 'nome', 'cognome', 'username', 'email', 'password', 'telefono', 'data_nascita', 'ruolo'
    ];

    protected $hidden = ['password', 'remember_token'];

    public function paziente()
    {
        return $this->hasOne(Paziente::class, 'codice_fiscale', 'codice_fiscale');
    }

    public function membroStaff()
    {
        return $this->hasOne(MembroStaff::class, 'codice_fiscale', 'codice_fiscale');
    }

    public function amministratore()
    {
        return $this->hasOne(Amministratore::class, 'codice_fiscale', 'codice_fiscale');
    }

    public function richieste()
    {
        return $this->hasMany(Richiesta::class, 'id_utente', 'codice_fiscale');
    }

    public function notifiche()
    {
        return $this->hasMany(Notifica::class, 'codice_fiscale', 'codice_fiscale');
    }

    public function getNameAttribute()
    {
        return $this->nome . ' ' . $this->cognome;
    }

    public function username()
    {
        return 'username';
    }

    public function medico()
    {
        return $this->hasOne(Medico::class);
    }

}

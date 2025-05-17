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
    public $incrementing = false; // perché è stringa, non auto-increment
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [
        'codice_fiscale', 'nome', 'cognome', 'email', 'password', 'telefono', 'data_nascita', 'foto', 'ruolo'
    ];

    protected $hidden = ['password', 'remember_token'];

    // Paziente: relazionato 1:1
    public function paziente()
    {
        return $this->hasOne(Paziente::class, 'codice_fiscale', 'codice_fiscale');
    }

    // Staff: relazionato 1:1
    public function membroStaff()
    {
        return $this->hasOne(MembroStaff::class, 'codice_fiscale', 'codice_fiscale');
    }

    // Admin: relazionato 1:1
    public function amministratore()
    {
        return $this->hasOne(Amministratore::class, 'codice_fiscale', 'codice_fiscale');
    }

    // Prenotazioni/Richieste
    public function richieste()
    {
        return $this->hasMany(Richiesta::class, 'id_utente', 'codice_fiscale');
    }

    // Notifiche ricevute
    public function notifiche()
    {
        return $this->hasMany(Notifica::class, 'id_utente', 'codice_fiscale');
    }

    public function getNameAttribute()
    {
        return $this->nome . ' ' . $this->cognome;
    }
}

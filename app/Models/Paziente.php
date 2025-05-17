<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paziente extends Model
{
    use HasFactory;
    protected $table = 'pazienti';
    public $timestamps = false;


    protected $primaryKey = 'codice_fiscale';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['codice_fiscale'];

    public function user()
    {
        return $this->belongsTo(User::class, 'codice_fiscale', 'codice_fiscale');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appuntamento extends Model
{
    use HasFactory;

    protected $table = 'appuntamenti';
    public $timestamps = false;

    protected $primaryKey = 'id_appuntamento';

    protected $fillable = [
        'id_richiesta', 'data', 'ora', 'stato'
    ];

    public function richiesta()
    {
        return $this->belongsTo(Richiesta::class, 'id_richiesta');
    }
}

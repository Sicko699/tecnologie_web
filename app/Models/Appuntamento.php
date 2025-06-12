<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Appuntamento extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($appuntamento) {
            $appuntamento->richiesta()->delete();
        });
    }

    protected $table = 'appuntamenti';
    public $timestamps = false;
    protected $primaryKey = 'id_appuntamento';

    protected $fillable = [
        'id_richiesta', 'data', 'ora', 'stato', 'codice_fiscale'
    ];

    public function richiesta()
    {
        return $this->belongsTo(Richiesta::class, 'id_richiesta');
    }

    public static function aggiornaErogati()
    {
        $oggi = now()->toDateString();
        $ora = now()->toTimeString();

        $richieste = Richiesta::where('stato', 'confermato')
            ->with(['appuntamenti'])
            ->get();

        foreach ($richieste as $richiesta) {
            foreach ($richiesta->appuntamenti as $app) {
                if (
                    $app->stato === 'prenotato' &&
                    (
                        $app->data < $oggi ||
                        ($app->data === $oggi && $app->ora < $ora)
                    )
                ) {
                    $app->stato = 'erogato';
                    $app->save();
                }
            }
        }
    }
}

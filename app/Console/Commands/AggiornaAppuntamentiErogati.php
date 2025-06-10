<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appuntamento;

class AggiornaAppuntamentiErogati extends Command
{
    protected $signature = 'appuntamenti:aggiorna-erogati';
    protected $description = 'Aggiorna lo stato degli appuntamenti confermati nel passato, impostandoli a "erogato".';

    public function handle()
    {
        Appuntamento::aggiornaErogati();

        $this->info('Appuntamenti aggiornati correttamente.');
    }
}


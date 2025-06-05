<?php

namespace Database\Seeders;

use App\Models\Medico;
use App\Models\Prestazione;

// === DENTISTI ===
$dentisti = [
    ['nome' => 'Luca', 'cognome' => 'Bianchi', 'specializzazione' => 'Odontoiatria generale'],
    ['nome' => 'Sara', 'cognome' => 'Rossi', 'specializzazione' => 'Ortodontista'],
    ['nome' => 'Giulia', 'cognome' => 'Neri', 'specializzazione' => 'Igienista dentale'],
];

foreach ($dentisti as $dati) {
    Medico::create($dati);
}

// === PRESTAZIONI ===
$prestazioni = [
    [
        'nome' => 'Pulizia dentale',
        'descrizione' => 'Rimozione placca e tartaro.',
        //'orari' => 'Lunedì - Mercoledì 10:00–13:00',
        'prescrizioni' => 'Non mangiare 1 ora prima.',
        'medico_id' => Medico::where('cognome', 'Neri')->first()->id,
    ],
    [
        'nome' => 'Visita ortodontica',
        'descrizione' => 'Controllo allineamento dentale.',
        //'orari' => 'Martedì e Giovedì 14:00–17:00',
        'prescrizioni' => 'Portare radiografie se disponibili.',
        'medico_id' => Medico::where('cognome', 'Rossi')->first()->id,
    ],
    [
        'nome' => 'Visita odontoiatrica',
        'descrizione' => 'Controllo generale dei denti e delle gengive.',
        //'orari' => 'Lunedì - Venerdì 09:00–12:00',
        'prescrizioni' => 'Lavare i denti prima della visita.',
        'medico_id' => Medico::where('cognome', 'Bianchi')->first()->id,
    ],
];

foreach ($prestazioni as $prestazione) {
    Prestazione::create($prestazione);
}


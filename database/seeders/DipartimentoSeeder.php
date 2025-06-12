<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DipartimentoSeeder extends Seeder
{
    public function run()
    {
        DB::table('dipartimenti')->insert([
            [
                'id_dipartimento' => 1,
                'nome' => 'Impiantologia Dentale',
                'descrizione' => 'L’implantologia dentale è una procedura di riabilitazione di alto valore estetico rivolta a chi, per vari motivi, ha perso i denti naturali.'
            ],
            [
                'id_dipartimento' => 2,
                'nome' => 'Igiene Dentale',
                'descrizione' => 'L\'igiene dentale è una pratica di profilassi e terapia della malattia parodontale e/o gengivale.'
            ],
            [
                'id_dipartimento' => 3,
                'nome' => 'Ortodonzia',
                'descrizione' => 'L\'ortodonzia è la branca dell\'odontoiatria che si occupa della correzione di disallineamenti dentali, problemi di malocclusione e alterazioni delle ossa mascellari e mandibolari.'
            ]
        ]);
    }
}

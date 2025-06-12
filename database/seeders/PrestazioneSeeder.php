<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrestazioneSeeder extends Seeder
{
    public function run()
    {
        DB::table('prestazioni')->insert([
            [
                'id_prestazione' => 1,
                'nome' => 'Ablazione Tartaro',
                'descrizione' => 'Un trattamento odontoiatrico che consiste nella rimozione meccanica dei depositi di tartaro.',
                'id_dipartimento' => 2,
                'id_membro' => 1,
            ],
            [
                'id_prestazione' => 2,
                'nome' => 'Malocclusioni dentali',
                'descrizione' => 'Le malocclusioni dentali sono un disallineamento dei denti, che conduce ad una scorretta chiusura del morso.',
                'id_dipartimento' => 3,
                'id_membro' => 2,
            ],
            [
                'id_prestazione' => 3,
                'nome' => 'Chirurgia orale',
                'descrizione' => 'Con chirurgia orale ci riferiamo alle tecniche chirurgiche messe in atto per risolvere problemi orali che non trovano soluzione in altri trattamenti medico-dentistici.',
                'id_dipartimento' => 1,
                'id_membro' => 3,
            ]
        ]);
    }
}

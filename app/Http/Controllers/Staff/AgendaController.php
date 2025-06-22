<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $dipartimento_id = optional($user->membroStaff)->id_dipartimento;

        $agende = Agenda::with(['dipartimento', 'prestazione'])
            ->when($dipartimento_id, function($q) use ($dipartimento_id) {
                $q->where('id_dipartimento', $dipartimento_id);
            })
            ->get();

        return view('staff.agenda.index', compact('agende'));
    }

    public function show(Agenda $agenda)
    {
        $user = Auth::user();
        $dipartimento_id = optional($user->membroStaff)->id_dipartimento;

        if ($dipartimento_id && $agenda->id_dipartimento != $dipartimento_id) {
            abort(403, 'Non hai accesso a questa agenda.');
        }

        return view('staff.agenda.show', compact('agenda'));
    }
}

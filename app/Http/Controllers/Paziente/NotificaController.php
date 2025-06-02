<?php

namespace App\Http\Controllers\Paziente;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificaController extends Controller
{
    public function markAllRead()
    {
        $user = Auth::user();
        $user->notifiche()->where('conferma_lettura', false)->update(['conferma_lettura' => true]);
        if (request()->ajax()) return response()->json(['status' => 'ok']);
        return back()->with('success', 'Notifiche segnate come lette!');
    }
}

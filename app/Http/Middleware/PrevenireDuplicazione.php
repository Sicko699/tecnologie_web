<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PrevenireDuplicazione
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('post') && $request->has('form_token')) {
            $sessionToken = session('form_token');
            $formToken = $request->input('form_token');
            if (!$sessionToken || !$formToken || $sessionToken !== $formToken) {
                return redirect()->back()->withInput()
                    ->with('warning', 'Modulo già inviato o token non valido, riprova.');
            }

            session()->forget('form_token');
        }
        return $next($request);
    }

}

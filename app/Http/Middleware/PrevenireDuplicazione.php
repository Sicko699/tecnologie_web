<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PrevenireDuplicazione
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Applichiamo solo ai POST (e solo se c'è il campo 'form_token')
        if ($request->isMethod('post') && $request->has('form_token')) {
            $sessionToken = session('form_token');
            $formToken = $request->input('form_token');
            if (!$sessionToken || !$formToken || $sessionToken !== $formToken) {
                return redirect()->back()->withInput()
                    ->with('warning', 'Modulo già inviato o token non valido, riprova.');
            }
            // Invalida subito il token
            session()->forget('form_token');
        }
        return $next($request);
    }

}

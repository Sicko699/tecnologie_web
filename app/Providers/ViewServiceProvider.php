<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Composer globale per tutte le view che finiscono per .create
        View::composer('*.create', function ($view) {
            $token = bin2hex(random_bytes(32));
            session(['form_token' => $token]);
            $view->with('token', $token);
        });
    }
}

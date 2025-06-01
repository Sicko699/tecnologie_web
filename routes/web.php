<?php

use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\RichiestaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RicercaController;
use App\Http\Controllers\Paziente\PrenotazioneController as PazientePrenotazioneController;
use App\Http\Controllers\Paziente\AppuntamentoController as PazienteAppuntamentoController;
use App\Http\Controllers\Paziente\ProfiloController as PazienteProfiloController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\Staff\AppuntamentoController as StaffAppuntamentoController;
use App\Http\Controllers\Staff\PrestazioneControllerStaff as StaffPrestazioneController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DipartimentoController as AdminDipartimentoController;
use App\Http\Controllers\Admin\PrestazioneController as AdminPrestazioneController;
use App\Http\Controllers\Admin\UtenteController as AdminUtenteController;
use App\Http\Controllers\Admin\AppuntamentoController as AdminAppuntamentoController;
use App\Http\Controllers\Admin\NotificaController as AdminNotificaController;
use App\Http\Controllers\Admin\StatisticaController as AdminStatisticaController;



// -------------------------------------
// PUBBLICO
// -------------------------------------
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/dottori', [PublicController::class, 'doctor'])->name('doctor.index');
Route::get('/trattamenti', [PublicController::class, 'department'])->name('department.index');
Route::get('/contatti', [PublicController::class, 'contact'])->name('contact');
Route::get('/about', [PublicController::class, 'about'])->name('about');
Route::post('/richiesta-pubblica', [RichiestaController::class, 'publicStore'])->name('richiesta.pubblica.store');


// Ricerca prestazioni (visibile a tutti)
Route::get('/ricerca/prestazioni', [RicercaController::class, 'index'])->name('ricerca.prestazioni');
Route::get('/ricerca', [RicercaController::class, 'index'])->name('ricerca.index');

// -------------------------------------
// ROUTE GENERICA PER DASHBOARD (PER TUTTI I RUOLI)
// -------------------------------------
Route::get('/dashboard', function () {
    \Log::info('Sono nella route dashboard', ['user' => Auth::user()]);
    if (Auth::check()) {
        $ruolo = Auth::user()->ruolo;
        if ($ruolo === 'admin') {
            \Log::info('Redirect admin');
            return redirect()->route('admin.dashboard');
        } elseif ($ruolo === 'staff') {
            \Log::info('Redirect staff');
            return redirect()->route('staff.dashboard');
        } else {
            \Log::info('Redirect paziente');
            return redirect()->route('paziente.dashboard');
        }
    }
    \Log::info('Non autenticato');
    return redirect()->route('login');
})->middleware(['auth'])->name('dashboard');

Route::get('/admin/dashboard', function() {
    \Log::info('Siamo dentro la dashboard admin');
    return 'Admin dashboard';
})->name('admin.dashboard');

// -------------------------------------
// ROUTE COMPATIBILE BREEZE/PROFILE
// -------------------------------------
Route::middleware(['auth'])->group(function () {
    // Questa route permette di usare route('profile.edit') nei template Breeze/Jetstream!
    Route::get('/profile', [PazienteProfiloController::class, 'show'])->name('profile.edit');
    Route::put('/profile', [PazienteProfiloController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [PazienteProfiloController::class, 'destroy'])->name('profile.destroy');
});

// -------------------------------------
// AUTENTICAZIONE (Laravel Breeze/Jetstream/etc.)
// -------------------------------------
require __DIR__.'/auth.php';

// -------------------------------------
// AREA PAZIENTE (auth + ruolo paziente)
// -------------------------------------
Route::middleware(['auth', 'role:paziente'])->prefix('user')->name('paziente.')->group(function () {
    Route::get('/dashboard', [PazientePrenotazioneController::class, 'dashboard'])->name('dashboard');
    // Profilo
    Route::get('/profilo', [PazienteProfiloController::class, 'show'])->name('profilo');
    Route::put('/profilo', [PazienteProfiloController::class, 'update'])->name('profilo.update');
    Route::delete('/account/delete', [PazienteProfiloController::class, 'destroy'])->name('account.delete');

    // Prenotazioni
    Route::resource('prenotazioni', PazientePrenotazioneController::class)->except(['dashboard']);
    // Appuntamenti
    Route::get('appuntamenti', [PazienteAppuntamentoController::class, 'index'])->name('appuntamenti.index');
});

// -------------------------------------
// AREA STAFF (auth + ruolo staff)
// -------------------------------------
Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');

    // Richieste pendenti (nuova route)
    Route::get('/richieste', [StaffAppuntamentoController::class, 'richiestePendenti'])->name('richieste.index');

    // Assegna appuntamento a richiesta (step di conferma slot)
    Route::get('/appuntamenti/create/{richiesta}', [StaffAppuntamentoController::class, 'create'])->name('appuntamenti.create');
    Route::post('/appuntamenti', [StaffAppuntamentoController::class, 'store'])->name('appuntamenti.store');

    // Gestione appuntamenti (modifica/annulla)
    Route::get('/appuntamenti', [StaffAppuntamentoController::class, 'index'])->name('appuntamenti.index');
    Route::get('/appuntamenti/{appuntamento}/edit', [StaffAppuntamentoController::class, 'edit'])->name('appuntamenti.edit');
    Route::put('/appuntamenti/{appuntamento}', [StaffAppuntamentoController::class, 'update'])->name('appuntamenti.update');
    Route::delete('/appuntamenti/{appuntamento}', [StaffAppuntamentoController::class, 'destroy'])->name('appuntamenti.destroy');

    // Agenda giornaliera (visualizzazione appuntamenti per prestazione e giorno)
    Route::get('/agenda', [StaffAppuntamentoController::class, 'agendaGiornalieraForm'])->name('agenda.giornaliera.form');
    Route::get('/agenda/giornaliera', [StaffAppuntamentoController::class, 'agendaGiornaliera'])->name('agenda.giornaliera');
    Route::resource('prestazioni', StaffPrestazioneController::class)->except(['show']);
});


// -------------------------------------
// AREA ADMIN (auth + ruolo admin)
// -------------------------------------
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    // CRUD su tutto
    Route::resource('dipartimenti', AdminDipartimentoController::class);
    Route::resource('prestazioni', AdminPrestazioneController::class);
    Route::resource('utenti', AdminUtenteController::class);
    Route::resource('appuntamenti', AdminAppuntamentoController::class);
    Route::resource('notifiche', AdminNotificaController::class)->only(['index', 'store', 'destroy']);
    Route::resource('statistiche', AdminStatisticaController::class)->only(['index', 'show']);
    Route::resource('agende', AgendaController::class);
    Route::get('agende/{id}/giornaliera', [AgendaController::class, 'giornaliera'])->name('agende.giornaliera');

});

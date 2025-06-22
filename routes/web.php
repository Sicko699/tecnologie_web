<?php

use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\AppuntamentoController as AdminAppuntamentoController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DipartimentoController as AdminDipartimentoController;
use App\Http\Controllers\Admin\NotificaController as AdminNotificaController;
use App\Http\Controllers\Admin\PrestazioneController as AdminPrestazioneController;
use App\Http\Controllers\Admin\StatisticaController as AdminStatisticaController;
use App\Http\Controllers\Admin\UtenteController as AdminUtenteController;
use App\Http\Controllers\Paziente\AppuntamentoController as PazienteAppuntamentoController;
use App\Http\Controllers\Paziente\NotificaController;
use App\Http\Controllers\Paziente\PrenotazioneController as PazientePrenotazioneController;
use App\Http\Controllers\Paziente\ProfiloController as PazienteProfiloController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RicercaController;
use App\Http\Controllers\RichiestaController;
use App\Http\Controllers\Staff\AppuntamentoController as StaffAppuntamentoController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\Staff\PrestazioneControllerStaff as StaffPrestazioneController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/dottori', [PublicController::class, 'doctor'])->name('doctor.index');
Route::get('/trattamenti', [PublicController::class, 'department'])->name('department.index');
Route::get('/trattamenti/{id}', [PublicController::class, 'show'])->name('prestazione.show');
Route::get('/contatti', [PublicController::class, 'contact'])->name('contact');
Route::get('/about', [PublicController::class, 'about'])->name('about');
Route::post('/richiesta-pubblica', [RichiestaController::class, 'publicStore'])->name('richiesta.pubblica.store');

Route::get('/ricerca/prestazioni', [RicercaController::class, 'index'])->name('ricerca.prestazioni');
Route::get('/ricerca', [RicercaController::class, 'index'])->name('ricerca.index');

Route::get('/dashboard', function () {
    if (Auth::check()) {
        $ruolo = Auth::user()->ruolo;
        if ($ruolo === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($ruolo === 'staff') {
            return redirect()->route('staff.dashboard');
        } else {
            return redirect()->route('paziente.dashboard');
        }
    }
    return redirect()->route('login');
})->middleware(['auth'])->name('dashboard');

Route::get('/admin/dashboard', function() {
    return 'Admin dashboard';
})->name('admin.dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [PazienteProfiloController::class, 'show'])->name('profile.edit');
    Route::put('/profile', [PazienteProfiloController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [PazienteProfiloController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'role:paziente'])->prefix('user')->name('paziente.')->group(function () {
    Route::get('/dashboard', [PazientePrenotazioneController::class, 'dashboard'])->name('dashboard');
    Route::get('/profilo', [PazienteProfiloController::class, 'show'])->name('profilo');
    Route::put('/profilo', [PazienteProfiloController::class, 'update'])->name('profilo.update');
    Route::delete('/account/delete', [PazienteProfiloController::class, 'destroy'])->name('account.delete');

    Route::resource('prenotazioni', PazientePrenotazioneController::class)->except(['store', 'dashboard']);

    Route::post('prenotazioni', [PazientePrenotazioneController::class, 'store'])
        ->middleware('no.duplicate')
        ->name('prenotazioni.store');

    Route::get('appuntamenti', [PazienteAppuntamentoController::class, 'index'])->name('appuntamenti.index');

    Route::post('/notifiche/mark-all-read', [NotificaController::class, 'markAllRead'])
        ->name('notifiche.markAllRead');
});

Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');

    Route::get('/richieste', [StaffAppuntamentoController::class, 'richiestePendenti'])->name('richieste.index');

    Route::get('/appuntamenti/create/{id_richiesta}', [StaffAppuntamentoController::class, 'create'])->name('appuntamenti.create');
    Route::post('/appuntamenti', [StaffAppuntamentoController::class, 'store'])
        ->middleware('no.duplicate')
        ->name('appuntamenti.store');

    Route::get('/appuntamenti', [StaffAppuntamentoController::class, 'index'])->name('appuntamenti.index');
    Route::get('/appuntamenti/{appuntamento}/edit', [StaffAppuntamentoController::class, 'edit'])->name('appuntamenti.edit');
    Route::put('/appuntamenti/{appuntamento}', [StaffAppuntamentoController::class, 'update'])->name('appuntamenti.update');
    Route::delete('/appuntamenti/{appuntamento}', [StaffAppuntamentoController::class, 'destroy'])->name('appuntamenti.destroy');

    Route::get('/agenda/giornaliera', [StaffAppuntamentoController::class, 'agendaGiornaliera'])->name('agenda.giornaliera');
    Route::get('/agenda', [\App\Http\Controllers\Staff\AgendaController::class, 'index'])->name('agenda.index');
    Route::get('/agenda/{agenda}', [\App\Http\Controllers\Staff\AgendaController::class, 'show'])->name('agenda.show');


    Route::resource('prestazioni', StaffPrestazioneController::class)->except(['show', 'store']);

    Route::post('prestazioni', [StaffPrestazioneController::class, 'store'])
        ->middleware('no.duplicate')
        ->name('prestazioni.store');

    Route::get('staff/membri/{id}/edit-prestazioni', [StaffPrestazioneController::class, 'editGestionePrestazioni'])->name('staff.membri.editPrestazioni');
    Route::put('staff/membri/{id}/update-prestazioni', [StaffPrestazioneController::class, 'updateGestionePrestazioni'])->name('staff.membri.updatePrestazioni');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('dipartimenti', AdminDipartimentoController::class)->except(['store']);
    Route::resource('prestazioni', AdminPrestazioneController::class)->except(['store']);
    Route::resource('utenti', AdminUtenteController::class)->except(['store']);
    Route::resource('appuntamenti', AdminAppuntamentoController::class)->except(['store']);
    Route::resource('notifiche', AdminNotificaController::class)->only(['index', 'destroy']);
    Route::resource('statistiche', AdminStatisticaController::class)->only(['index', 'show']);
    Route::resource('agende', AgendaController::class)->except(['store']);
    Route::get('agende/{id}/giornaliera', [AgendaController::class, 'giornaliera'])->name('agende.giornaliera');
    Route::get('prestazioni/{prestazioni}', [AdminPrestazioneController::class, 'show'])->name('prestazioni.show');

    Route::post('dipartimenti', [AdminDipartimentoController::class, 'store'])
        ->middleware('no.duplicate')
        ->name('dipartimenti.store');
    Route::post('prestazioni', [AdminPrestazioneController::class, 'store'])
        ->middleware('no.duplicate')
        ->name('prestazioni.store');
    Route::post('utenti', [AdminUtenteController::class, 'store'])
        ->middleware('no.duplicate')
        ->name('utenti.store');
    Route::post('appuntamenti', [AdminAppuntamentoController::class, 'store'])
        ->middleware('no.duplicate')
        ->name('appuntamenti.store');
    Route::post('agende', [AgendaController::class, 'store'])
        ->middleware('no.duplicate')
        ->name('agende.store');
    Route::post('notifiche', [AdminNotificaController::class, 'store'])
        ->middleware('no.duplicate')
        ->name('notifiche.store');
}

);


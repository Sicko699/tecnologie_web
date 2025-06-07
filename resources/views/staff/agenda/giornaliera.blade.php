@extends('layouts.app')
@section('title', 'Appuntamenti in agenda')

@php use Carbon\Carbon; @endphp

@section('content')
    <div class="container py-5">
        <h2 class="fw-bold mb-4">
            <i class="fas fa-calendar-alt me-2 text-info"></i> Appuntamenti in Agenda
        </h2>

        <div class="table-responsive" style="border-radius: 14px; overflow: hidden;">
            <table class="table table-borderless align-middle bg-white shadow-sm mb-0" style="border-radius:14px;">
                <thead class="table-light">
                <tr>
                    <th>Data</th>
                    <th>Orario</th>
                    <th>Utente</th>
                    <th>Prestazione</th>
                    <th>Stato</th>
                    <th class="text-end" style="min-width:130px;">Azioni</th>
                </tr>
                </thead>
                <tbody>
                @foreach($appuntamenti as $a)
                    <tr>
                        <td>{{ $a->data }}</td>
                        <td>
                            {{
                                Carbon::createFromFormat('H:i:s', $a->ora)->format('H:i')
                            }} - {{
                                Carbon::createFromFormat('H:i:s', $a->ora)->addHour()->format('H:i')
                            }}
                        </td>
                        <td>{{ $a->richiesta->utente->name ?? $a->richiesta->utente->codice_fiscale }}</td>
                        <td>{{ $a->richiesta->prestazione->nome }}</td>
                        <td>
                            <span class="badge rounded-pill {{ $a->stato === 'prenotato' ? 'bg-primary' : ($a->stato === 'erogato' ? 'bg-success' : 'bg-secondary') }}">
                                {{ ucfirst($a->stato) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('staff.appuntamenti.edit', ['appuntamento' => $a->id_appuntamento]) }}"
                               class="btn btn-outline-warning btn-sm me-1" style="border-radius:18px;">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('staff.appuntamenti.destroy', ['appuntamento' => $a->id_appuntamento]) }}"
                                  method="POST" style="display:inline;"
                                  onsubmit="return confirm('Confermi eliminazione?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm" style="border-radius:18px;">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <a href="{{ route('staff.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i> Indietro
            </a>
        </div>
    </div>
    <style>
        .table { border-radius: 14px; overflow: hidden; }
        .badge { font-size: 1em; }
        .btn-outline-warning, .btn-outline-danger { min-width:36px; }
        .btn-outline-warning i, .btn-outline-danger i { vertical-align: middle; }
    </style>
@endsection

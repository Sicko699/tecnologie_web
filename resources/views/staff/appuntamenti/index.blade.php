@extends('layouts.app')
@section('title', 'Appuntamenti in agenda')

@php use Carbon\Carbon; @endphp

@section('content')
    <div class="container py-5">
        <h2 class="fw-bold mb-4">
            <i class="fas fa-calendar-alt me-2 text-info"></i> Appuntamenti in Agenda
        </h2>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                <tr>
                    <th>Data</th>
                    <th>Orario</th>
                    <th>Utente</th>
                    <th>Prestazione</th>
                    <th>Stato</th>
                    <th>Azioni</th>
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
                            <span class="badge text-bg-{{ $a->stato === 'prenotato' ? 'primary' : ($a->stato === 'erogato' ? 'success' : 'secondary') }}">
                                {{ ucfirst($a->stato) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('staff.appuntamenti.edit', ['appuntamento' => $a->id_appuntamento]) }}"
                               class="btn btn-outline-warning btn-sm me-1">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('staff.appuntamenti.destroy', ['appuntamento' => $a->id_appuntamento]) }}"
                                  method="POST" class="d-inline" onsubmit="return confirm('Confermi eliminazione?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

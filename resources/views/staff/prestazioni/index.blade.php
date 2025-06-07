@extends('layouts.app')
@section('title', 'Prestazioni Gestite')

@section('content')
    <style>
        .table thead th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .custom-table {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .table td, .table th {
            vertical-align: middle;
        }

        .no-data {
            padding: 2rem;
            color: #6c757d;
        }
    </style>

    <div class="container py-5">


        <div class="table-responsive custom-table">
            <table class="table table-striped align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th><i class="fas fa-file-medical me-1 text-secondary"></i> Nome</th>
                    <th><i class="fas fa-building me-1 text-secondary"></i> Dipartimento</th>
                    <th><i class="fas fa-align-left me-1 text-secondary"></i> Descrizione</th>
                </tr>
                </thead>
                <tbody>
                @forelse($prestazioni as $prestazione)
                    <tr>
                        <td>{{ $prestazione->nome }}</td>
                        <td>{{ $prestazione->dipartimento->nome }}</td>
                        <td>{{ $prestazione->descrizione }}</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center no-data">
                            <i class="fas fa-inbox me-2"></i> Nessuna prestazione disponibile
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Cerca Prestazioni')

@section('content')
    <div class="container py-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h2 class="mb-4"><i class="bi bi-search"></i> Cerca Prestazioni</h2>

                <form method="GET" action="{{ route('ricerca.prestazioni') }}">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Inserisci nome prestazione o dipartimento (usa * per wildcard)" value="{{ request('q') }}">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Cerca</button>
                    </div>
                </form>

                @if(isset($risultati))
                    <hr class="my-4">

                    <h4 class="mb-3"><i class="bi bi-list-check"></i> Risultati</h4>

                    @if($risultati->isEmpty())
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle-fill"></i> Nessuna prestazione trovata.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                <tr>
                                    <th scope="col">Nome Prestazione</th>
                                    <th scope="col">Dipartimento</th>
                                    <th scope="col">Descrizione</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($risultati as $prestazione)
                                    <tr onclick="window.location='{{ route('prestazione.show', $prestazione->id_prestazione) }}'" style="cursor: pointer;">
                                        <td><strong>{{ $prestazione->nome }}</strong></td>
                                        <td>{{ $prestazione->dipartimento->nome ?? 'N/A' }}</td>
                                        <td>{{ Str::limit($prestazione->descrizione, 80) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection

@extends('lapor.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Daftar Tiket Anda</h4>
    <a href="{{ route('lapor.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Buka Tiket Baru</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        @if($tickets->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No. Tiket</th>
                            <th>Subjek</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->ticket_number }}</td>
                                <td>{{ Str::limit($ticket->subject, 50) }}</td>
                                <td>{{ $ticket->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    @if($ticket->status == 'Open')
                                        <span class="badge bg-warning text-dark">Open</span>
                                    @elseif($ticket->status == 'Proses')
                                        <span class="badge bg-info text-dark">Proses</span>
                                    @else
                                        <span class="badge bg-success">Closed</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('lapor.show', $ticket->id) }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center text-muted py-4">
                <p>Belum ada tiket yang dibuat.</p>
            </div>
        @endif
    </div>
</div>
@endsection

@extends('lapor.layouts.app')

@section('title', 'Detail Tiket ' . $ticket->ticket_number)

@section('content')
<div class="mb-3">
    <a href="{{ route('lapor.dashboard') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Kembali ke Dashboard</a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{ $ticket->subject }}</h5>
        <div>
            <span class="badge bg-secondary">{{ $ticket->ticket_number }}</span>
            @if($ticket->status == 'Open')
                <span class="badge bg-warning text-dark">Open</span>
            @elseif($ticket->status == 'Proses')
                <span class="badge bg-info text-dark">Proses</span>
            @else
                <span class="badge bg-success">Closed</span>
            @endif
        </div>
    </div>
    <div class="card-body bg-light" style="max-height: 500px; overflow-y: auto;">
        @foreach($ticket->messages as $msg)
            <div class="mb-4">
                <div class="d-flex {{ $msg->sender_type == 'reporter' ? 'justify-content-end' : 'justify-content-start' }}">
                    <div class="card {{ $msg->sender_type == 'reporter' ? 'bg-primary text-white' : 'bg-white border' }}" style="max-width: 75%;">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between mb-2" style="font-size: 0.85rem; {{ $msg->sender_type == 'reporter' ? 'color: #e0e0e0;' : 'color: #6c757d;' }}">
                                <strong>{{ $msg->sender_name }}</strong>
                                <span class="ms-3">{{ $msg->created_at->format('d M Y H:i') }}</span>
                            </div>
                            <p class="mb-0" style="white-space: pre-wrap;">{{ $msg->message }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@if($ticket->status !== 'Closed')
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('lapor.reply', $ticket->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="message" class="form-label">Tulis Balasan</label>
                    <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i> Kirim</button>
                </div>
            </form>
        </div>
    </div>
@else
    <div class="alert alert-secondary text-center">
        Tiket ini sudah ditutup. Anda tidak dapat membalas pesan lagi.
    </div>
@endif
@endsection

@extends('admin.layouts.app')

@section('title', 'Baca Tiket')
@section('page_title', 'Merespon Tiket Lapor SDM')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <h3 class="profile-username text-center">{{ $ticket->reporter->name }}</h3>
                <p class="text-muted text-center">{{ strtoupper($ticket->reporter->type) }}</p>
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Email</b> <a class="float-end text-decoration-none">{{ $ticket->reporter->email }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>WhatsApp</b> <a class="float-end text-decoration-none">{{ $ticket->reporter->whatsapp }}</a>
                    </li>
                    @if($ticket->reporter->type === 'asn')
                    <li class="list-group-item">
                        <b>NIP</b> <a class="float-end text-decoration-none">{{ $ticket->reporter->nip }}</a>
                    </li>
                    @else
                    <li class="list-group-item">
                        <b>NIK</b> <a class="float-end text-decoration-none">{{ $ticket->reporter->nik }}</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Baca Pesan</h3>
                <div class="card-tools">
                    <span class="badge text-bg-{{ $ticket->status == 'Closed' ? 'success' : ($ticket->status == 'Proses' ? 'info' : 'warning') }}">{{ $ticket->status }}</span>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="mailbox-read-info">
                    <h5>{{ $ticket->subject }} <small class="text-muted float-end">{{ $ticket->ticket_number }}</small></h5>
                    <h6>Dari: {{ $ticket->reporter->email }}
                        <span class="mailbox-read-time float-end">{{ $ticket->created_at->format('d M. Y h:i A') }}</span>
                    </h6>
                </div>
                
                <div class="mailbox-read-message" style="background-color: #f8f9fa; padding: 15px; border-bottom: 1px solid #dee2e6;">
                    <strong>Riwayat Percakapan:</strong>
                </div>

                <div class="p-3" style="max-height: 500px; overflow-y: auto;">
                    @foreach($ticket->messages as $msg)
                        <div class="mb-3">
                            <div class="d-flex {{ $msg->sender_type == 'admin' ? 'justify-content-end' : 'justify-content-start' }}">
                                <div class="card {{ $msg->sender_type == 'admin' ? 'bg-primary text-white' : 'bg-light border' }}" style="max-width: 75%;">
                                    <div class="card-body p-2 px-3">
                                        <div class="mb-1" style="font-size: 0.8rem; opacity: 0.8;">
                                            <strong>{{ $msg->sender_name }}</strong> - {{ $msg->created_at->format('d M Y H:i') }}
                                        </div>
                                        <div style="white-space: pre-wrap;">{{ $msg->message }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <div class="card-footer">
                <form action="{{ route('admin.tickets.reply', $ticket->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Balas / Update Status</label>
                        <textarea name="message" class="form-control" rows="4" placeholder="Tuliskan jawaban atau keterangan..."></textarea>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="w-25">
                            <select name="status" class="form-select">
                                <option value="Open" {{ $ticket->status == 'Open' ? 'selected' : '' }}>Biarkan Open</option>
                                <option value="Proses" {{ $ticket->status == 'Proses' ? 'selected' : '' }}>Tandai Proses</option>
                                <option value="Closed" {{ $ticket->status == 'Closed' ? 'selected' : '' }}>Tandai Closed</option>
                            </select>
                        </div>
                        <div>
                            <a href="{{ route('admin.tickets.index') }}" class="btn btn-default"><i class="bi bi-x"></i> Batal</a>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i> Kirim Balasan & Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('admin.layouts.app')

@section('title', 'Lapor SDM Inbox')
@section('page_title', 'Inbox Lapor SDM')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Inbox Tiket</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive mailbox-messages">
                    <table class="table table-hover table-striped">
                        <tbody>
                            @forelse($tickets as $ticket)
                                <tr>
                                    <td class="mailbox-name"><a href="{{ route('admin.tickets.show', $ticket->id) }}">{{ $ticket->reporter->name }}</a></td>
                                    <td class="mailbox-subject">
                                        <b>{{ $ticket->ticket_number }}</b> - {{ Str::limit($ticket->subject, 60) }}
                                    </td>
                                    <td class="mailbox-attachment">
                                        @if($ticket->status == 'Open')
                                            <span class="badge text-bg-warning">Open</span>
                                        @elseif($ticket->status == 'Proses')
                                            <span class="badge text-bg-info">Proses</span>
                                        @else
                                            <span class="badge text-bg-success">Closed</span>
                                        @endif
                                    </td>
                                    <td class="mailbox-date">{{ $ticket->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Belum ada tiket laporan masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer p-0">
                <div class="mailbox-controls">
                    <div class="float-end">
                        {{ $tickets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

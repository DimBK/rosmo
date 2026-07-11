<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Support\Facades\Auth;

class TicketManagementController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with('reporter')->latest()->paginate(15);
        return view('admin.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        $ticket->load('messages', 'reporter');
        return view('admin.tickets.show', compact('ticket'));
    }

    public function reply(Request $request, Ticket $ticket)
    {
        $request->validate([
            'message' => 'required|string',
            'status' => 'required|in:Open,Proses,Closed',
        ]);

        TicketMessage::create([
            'ticket_id' => $ticket->id,
            'sender_type' => 'admin',
            'sender_id' => Auth::id(),
            'message' => $request->message,
        ]);

        if ($ticket->status !== $request->status) {
            $ticket->update(['status' => $request->status]);
        }

        return back()->with('success', 'Balasan berhasil dikirim dan status diperbarui.');
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => 'required|in:Open,Proses,Closed',
        ]);

        $ticket->update(['status' => $request->status]);
        return back()->with('success', 'Status tiket diperbarui.');
    }
}

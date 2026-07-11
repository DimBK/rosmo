<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function dashboard()
    {
        $reporter = Auth::guard('reporter')->user();
        $tickets = $reporter->tickets()->latest()->get();
        return view('lapor.dashboard', compact('tickets'));
    }

    public function create()
    {
        return view('lapor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $reporter = Auth::guard('reporter')->user();

        // Generate Ticket Number
        $ticketNumber = 'TKT-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

        $ticket = Ticket::create([
            'reporter_id' => $reporter->id,
            'ticket_number' => $ticketNumber,
            'subject' => $request->subject,
            'status' => 'Open',
        ]);

        TicketMessage::create([
            'ticket_id' => $ticket->id,
            'sender_type' => 'reporter',
            'sender_id' => $reporter->id,
            'message' => $request->message,
        ]);

        return redirect()->route('lapor.dashboard')->with('success', 'Tiket berhasil dibuat.');
    }

    public function show(Ticket $ticket)
    {
        // Ensure the ticket belongs to the authenticated reporter
        if ($ticket->reporter_id !== Auth::guard('reporter')->id()) {
            abort(403);
        }

        $ticket->load('messages');
        return view('lapor.show', compact('ticket'));
    }

    public function reply(Request $request, Ticket $ticket)
    {
        if ($ticket->reporter_id !== Auth::guard('reporter')->id()) {
            abort(403);
        }

        if ($ticket->status === 'Closed') {
            return back()->with('error', 'Tiket sudah ditutup, tidak dapat dibalas.');
        }

        $request->validate([
            'message' => 'required|string',
        ]);

        TicketMessage::create([
            'ticket_id' => $ticket->id,
            'sender_type' => 'reporter',
            'sender_id' => Auth::guard('reporter')->id(),
            'message' => $request->message,
        ]);

        // If the ticket was Proses, it remains Proses. If Open, it remains Open.
        return back()->with('success', 'Pesan berhasil dikirim.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    // User functions
    public function index()
    {
        $tickets = Ticket::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('tickets.index', compact('tickets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:help,hiring',
        ]);

        $ticket = Ticket::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'status' => 'open',
        ]);

        return redirect()->route('tickets.show', $ticket->id)->with('success', 'রিকোয়েস্ট সফলভাবে সাবমিট হয়েছে।');
    }

    public function show($id)
    {
        $ticket = Ticket::where('user_id', Auth::id())->with('messages.sender')->findOrFail($id);
        return view('tickets.show', compact('ticket'));
    }

    public function storeMessage(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        // Security check: only ticket owner or admin can reply
        if ($ticket->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'message' => 'required|string',
        ]);

        TicketMessage::create([
            'ticket_id' => $ticket->id,
            'sender_id' => Auth::id(),
            'message' => $request->message,
        ]);

        // Keep status open/in_progress on user message, or whatever
        if (Auth::user()->role === 'admin' && $ticket->status === 'open') {
            $ticket->status = 'in_progress';
            $ticket->save();
        }

        return back()->with('success', 'বার্তা পাঠানো হয়েছে।');
    }

    public function closeTicket($id)
    {
        $ticket = Ticket::findOrFail($id);
        if ($ticket->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $ticket->status = 'closed';
        $ticket->save();

        return back()->with('success', 'টিকিটটি বন্ধ করা হয়েছে।');
    }

    // Admin functions
    public function adminIndex()
    {
        $tickets = Ticket::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.tickets', compact('tickets'));
    }

    public function adminShow($id)
    {
        $ticket = Ticket::with('messages.sender', 'user')->findOrFail($id);
        return view('admin.ticket_show', compact('ticket'));
    }
}

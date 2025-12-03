<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RopaIssue;
use App\Models\Ropa;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\TicketAlertMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RopaIssueController extends Controller
{
    /**
     * Display the Ticket Dashboard
     */
  public function index()
{
    $user = auth()->user();

    if ($user->role === 'admin') {

        $pending_tickets = Ticket::where('status', 'open')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $completed_tickets = Ticket::where('status', 'completed')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        $pending_count = Ticket::where('status', 'open')->count();
        $completed_count = Ticket::where('status', 'completed')->count();

        $ropas = Ropa::all();

        // 👉 FIX: return admin index view
        return view('admindashboard.ticket.index', compact(
            'pending_tickets',
            'completed_tickets',
            'pending_count',
            'completed_count',
            'ropas'
        ));
    }

    // ---------------------------------------------
    // NON-ADMIN USERS
    // ---------------------------------------------
    $pending_tickets = RopaIssue::where('user_id', $user->id)
        ->where('status', 'open')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    $completed_tickets = RopaIssue::where('user_id', $user->id)
        ->where('status', 'completed')
        ->orderBy('updated_at', 'desc')
        ->paginate(10);

    $pending_count = RopaIssue::where('user_id', $user->id)
        ->where('status', 'open')
        ->count();

    $completed_count = RopaIssue::where('user_id', $user->id)
        ->where('status', 'completed')
        ->count();

    $ropas = Ropa::where('user_id', $user->id)->get();

    // 👉 FIX: return user index view
    return view('ticket.index', compact(
        'pending_tickets',
        'completed_tickets',
        'pending_count',
        'completed_count',
        'ropas'
    ));
}



    /**
     * Store a new ticket + send email
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ropa_id'     => 'required|exists:ropas,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'risk_level'  => 'required|in:low,medium,high,critical',
        ]);

        // Create ticket
        $ticket = RopaIssue::create([
            'ropa_id'     => $validated['ropa_id'],
            'user_id'     => Auth::id(),
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'risk_level'  => $validated['risk_level'],
            'status'      => 'open',
        ]);

        // -----------------------------------------------------------
        // SEND EMAIL TO ALL ACTIVE ADMINS
        // -----------------------------------------------------------
        $adminEmails = User::where('user_type', 1)
            ->where('active', 1)
            ->pluck('email')
            ->toArray();

        if (count($adminEmails) > 0) {
            try {

                Mail::to($adminEmails)->send(new TicketAlertMail($ticket));

                Log::info("Ticket alert sent to admins", [
                    'ticket_id' => $ticket->id,
                    'admin_count' => count($adminEmails),
                ]);

            } catch (\Throwable $e) {

                Log::error("Failed sending admin ticket email", [
                    'ticket_id' => $ticket->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return redirect()->route('ticket.index')
            ->with('success', 'Ticket created successfully.');
    }


    /**
     * Display a single ticket
     */
    public function show(string $id)
    {
        $issue = RopaIssue::with(['user', 'ropa'])->findOrFail($id);
        return view('ticket.show', compact('issue'));
    }


    /**
     * Edit ticket
     */
    public function edit(string $id)
    {
        $issue = RopaIssue::findOrFail($id);
        $ropas = Ropa::all();

        return view('ticket.edit', compact('issue', 'ropas'));
    }


    

    /**
     * Update ticket
     */
    public function update(Request $request, string $id)
{
    $issue = RopaIssue::findOrFail($id);

    // -------------------------------------------------------
    // Validate input
    // -------------------------------------------------------
    $validated = $request->validate([
        'ropa_id'     => 'required|exists:ropas,id',
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string',
        'risk_level'  => 'required|in:low,medium,high,critical',
        'status'      => 'required|in:open,resolved',
    ]);

    // -------------------------------------------------------
    // Log previous values before updating
    // -------------------------------------------------------
    $previousStatus   = $issue->status;
    $previousRisk     = $issue->risk_level;

    // -------------------------------------------------------
    // Auto-set resolved_at timestamp if status changes to resolved
    // -------------------------------------------------------
    if ($validated['status'] === 'resolved' && $issue->resolved_at === null) {
        $validated['resolved_at'] = now();
    }

    // -------------------------------------------------------
    // Update the issue
    // -------------------------------------------------------
    $issue->update($validated);

    // -------------------------------------------------------
    // Save status change history
    // -------------------------------------------------------
    if ($previousStatus !== $validated['status']) {
        RopaIssue::create([
            'issue_id'   => $issue->id,
            'changed_by' => auth()->id(),
            'old_status' => $previousStatus,
            'new_status' => $validated['status'],
        ]);
    }

    // -------------------------------------------------------
    // Save risk-level change history
    // -------------------------------------------------------
    if ($previousRisk !== $validated['risk_level']) {
        IssueHistory::create([
            'issue_id'   => $issue->id,
            'changed_by' => auth()->id(),
            'old_status' => $previousRisk,
            'new_status' => $validated['risk_level'],
        ]);
    }

    return redirect()->route('ticket.index')
        ->with('success', 'Ticket updated successfully.');
}


    /**
     * Delete ticket
     */
    public function destroy(string $id)
    {
        $issue = RopaIssue::findOrFail($id);
        $issue->delete();

        return redirect()->route('ticket.index')
            ->with('success', 'Ticket deleted successfully.');
    }
}

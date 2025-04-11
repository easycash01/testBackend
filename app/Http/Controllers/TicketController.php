<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Costruttore del controller
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Visualizza tutti i ticket
     * Rep_IT può vedere tutti i ticket, i dipendenti solo i propri
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->hasRole('rep_it')) {
            // Gli utenti rep_it possono vedere tutti i ticket con i dati del richiedente
            $tickets = Ticket::with('richiedente:id,name,email')->get();
        } else {
            // I dipendenti possono vedere solo i propri ticket con i dati del richiedente
            $tickets = Ticket::with('richiedente:id,name,email')->where('requester_id', $user->id)->get();
        }
        
        return response()->json(['tickets' => $tickets]);
    }

    /**
     * Visualizza un ticket specifico
     */
    public function show($id)
    {
        $user = Auth::user();
        
        if ($user->hasRole('rep_it')) {
            // Per i rep_it, includi i dati del richiedente
            $ticket = Ticket::with('richiedente:id,name,email')->findOrFail($id);
        } else {
            // Per i dipendenti, includi i dati del richiedente
            $ticket = Ticket::with('richiedente:id,name,email')->findOrFail($id);
            
            // Verifica se l'utente può visualizzare questo ticket
            if ($ticket->requester_id !== $user->id) {
                return response()->json(['error' => 'Non autorizzato a visualizzare questo ticket'], 403);
            }
        }
        
        return response()->json(['ticket' => $ticket]);
    }

    /**
     * Crea un nuovo ticket
     */
    public function store(Request $request)
    {
        $request->validate([
            'titolo' => 'required|string|max:255',
            'descrizione' => 'required|string',
        ]);

        $ticket = Ticket::create([
            'titolo' => $request->titolo,
            'descrizione' => $request->descrizione,
            'requester_id' => Auth::id(),
            'stato' => 'Aperto',
        ]);

        return response()->json([
            'message' => 'Ticket creato con successo',
            'ticket' => $ticket
        ], 201);
    }

    /**
     * Aggiorna lo stato di un ticket
     * Solo rep_it può cambiare lo stato
     */
    public function updateStatus(Request $request, $id)
    {
        $user = Auth::user();
        
        if (!$user->hasRole('rep_it')) {
            return response()->json(['error' => 'Solo i rappresentanti IT possono aggiornare lo stato dei ticket'], 403);
        }
        
        $request->validate([
            'stato' => 'required|in:Aperto,Working,Chiuso',
        ]);
        
        $ticket = Ticket::findOrFail($id);
        $ticket->stato = $request->stato;
        $ticket->save();
        
        return response()->json([
            'message' => 'Stato del ticket aggiornato con successo',
            'ticket' => $ticket
        ]);
    }

    /**
     * Elimina un ticket
     * Solo rep_it può eliminare i ticket
     */
    public function destroy($id)
    {
        $user = Auth::user();
        
        if (!$user->hasRole('rep_it')) {
            return response()->json(['error' => 'Solo i rappresentanti IT possono eliminare i ticket'], 403);
        }
        
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();
        
        return response()->json(['message' => 'Ticket eliminato con successo']);
    }
}
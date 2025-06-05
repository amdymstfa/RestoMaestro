<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * Display a listing of reservations
     */
    public function index(Request $request)
    {
        $query = Reservation::with(['table', 'creator']);
        
        // Filtres
        if ($request->filled('date')) {
            $query->whereDate('reservation_time', $request->date);
        }
        
        if ($request->filled('status')) {
            // Logique de filtrage par statut basée sur l'heure
            $now = Carbon::now();
            switch ($request->status) {
                case 'upcoming':
                    $query->where('reservation_time', '>', $now);
                    break;
                case 'past':
                    $query->where('reservation_time', '<', $now);
                    break;
                case 'today':
                    $query->whereDate('reservation_time', Carbon::today());
                    break;
            }
        }
        
        if ($request->filled('table_id')) {
            $query->where('table_id', $request->table_id);
        }
        
        $reservations = $query->orderBy('reservation_time', 'desc')->paginate(15);
        
        // Pour les filtres
        $tables = Table::orderBy('number')->get();
        
        return view('manager.reservations.index', compact('reservations', 'tables'));
    }

    /**
     * Show the form for creating a new reservation
     */
    public function create()
    {
        $tables = Table::where('status', '!=', 'out_of_service')
            ->orderBy('number')
            ->get();
            
        return view('manager.reservations.create', compact('tables'));
    }

    /**
     * Store a newly created reservation
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_name' => ['required', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:20'],
            'reservation_time' => ['required', 'date', 'after:now'],
            'table_id' => ['required', 'exists:tables,id'],
        ]);

        // Vérifier les conflits
        $conflictingReservation = Reservation::where('table_id', $request->table_id)
            ->where('reservation_time', $request->reservation_time)
            ->first();
            
        if ($conflictingReservation) {
            return back()->withErrors(['table_id' => 'Cette table est déjà réservée à cette heure.']);
        }

        Reservation::create([
            'client_name' => $request->client_name,
            'phone' => $request->phone,
            'reservation_time' => $request->reservation_time,
            'table_id' => $request->table_id,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('manager.reservations.index')
            ->with('success', 'Réservation créée avec succès.');
    }

    /**
     * Display the specified reservation
     */
    public function show(Reservation $reservation)
    {
        $reservation->load(['table', 'creator']);
        return view('manager.reservations.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified reservation
     */
    public function edit(Reservation $reservation)
    {
        $tables = Table::where('status', '!=', 'out_of_service')
            ->orderBy('number')
            ->get();
            
        return view('manager.reservations.edit', compact('reservation', 'tables'));
    }

    /**
     * Update the specified reservation
     */
    public function update(Request $request, Reservation $reservation)
    {
        $validatedData = $request->validate([
            'client_name' => ['required', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:20'],
            'reservation_time' => ['required', 'date', 'after:now'],
            'table_id' => ['required', 'exists:tables,id'],
        ]);

        // Vérifier les conflits (exclure la réservation actuelle)
        $conflictingReservation = Reservation::where('table_id', $request->table_id)
            ->where('reservation_time', $request->reservation_time)
            ->where('id', '!=', $reservation->id)
            ->first();
            
        if ($conflictingReservation) {
            return back()->withErrors(['table_id' => 'Cette table est déjà réservée à cette heure.']);
        }

        $reservation->update($validatedData);

        return redirect()->route('manager.reservations.show', $reservation)
            ->with('success', 'Réservation mise à jour avec succès.');
    }

    /**
     * Remove the specified reservation
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('manager.reservations.index')
            ->with('success', 'Réservation supprimée avec succès.');
    }

    /**
     * Confirm a reservation
     */
    public function confirm(Reservation $reservation)
    {
        // Logique de confirmation (peut être étendue)
        return back()->with('success', 'Réservation confirmée.');
    }

    /**
     * Cancel a reservation
     */
    public function cancel(Reservation $reservation)
    {
        $reservation->delete();
        return back()->with('success', 'Réservation annulée.');
    }
}

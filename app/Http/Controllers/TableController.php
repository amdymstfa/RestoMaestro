<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\Order;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Display a listing of tables
     */
    public function index(Request $request)
    {
        $query = Table::query();
        
        // Filtres
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('seats')) {
            $query->where('seats', '>=', $request->seats);
        }
        
        $tables = $query->orderBy('number')->paginate(20);
        
        return view('manager.tables.index', compact('tables'));
    }

    /**
     * Show the form for creating a new table
     */
    public function create()
    {
        return view('manager.tables.create');
    }

    /**
     * Store a newly created table
     */
    public function store(Request $request)
    {
        $request->validate([
            'number' => ['required', 'integer', 'unique:tables,number'],
            'seats' => ['required', 'integer', 'min:1', 'max:20'],
        ]);

        Table::create([
            'number' => $request->number,
            'seats' => $request->seats,
            'status' => 'free',
        ]);

        return redirect()->route('manager.tables.index')
            ->with('success', 'Table créée avec succès.');
    }

    /**
     * Display the specified table
     */
    public function show(Table $table)
    {
        $currentOrder = Order::where('table_id', $table->id)
            ->whereIn('status', ['pending', 'preparing', 'served'])
            ->with('orderItems.menu')
            ->first();
            
        $recentOrders = Order::where('table_id', $table->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        return view('manager.tables.show', compact('table', 'currentOrder', 'recentOrders'));
    }

    /**
     * Show the form for editing the specified table
     */
    public function edit(Table $table)
    {
        return view('manager.tables.edit', compact('table'));
    }

    /**
     * Update the specified table
     */
    public function update(Request $request, Table $table)
    {
        $validatedData = $request->validate([
            'number' => ['required', 'integer', 'unique:tables,number,' . $table->id],
            'seats' => ['required', 'integer', 'min:1', 'max:20'],
        ]);

        $table->update($validatedData);

        return redirect()->route('manager.tables.show', $table)
            ->with('success', 'Table mise à jour avec succès.');
    }

    /**
     * Remove the specified table
     */
    public function destroy(Table $table)
    {
        // Vérifier qu'il n'y a pas de commandes actives
        $activeOrders = Order::where('table_id', $table->id)
            ->whereIn('status', ['pending', 'preparing', 'served'])
            ->count();
            
        if ($activeOrders > 0) {
            return back()->withErrors(['table' => 'Impossible de supprimer une table avec des commandes actives.']);
        }

        $table->delete();

        return redirect()->route('manager.tables.index')
            ->with('success', 'Table supprimée avec succès.');
    }

    /**
     * Update table status
     */
    public function updateStatus(Request $request, Table $table)
    {
        $request->validate([
            'status' => ['required', 'in:free,occupied,reserved'],
        ]);

        $table->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Statut de la table mis à jour.',
            'status' => $table->status
        ]);
    }
}

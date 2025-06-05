<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of orders
     */
    public function index()
    {
        $orders = Order::with(['table', 'orderItems.menu', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('manager.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new order
     */
    public function create()
    {
        $tables = Table::where('status', 'occupied')->get();
        $menus = Menu::all()->groupBy('type');
        
        return view('manager.orders.create', compact('tables', 'menus'));
    }

    /**
     * Store a newly created order
     */
    public function store(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id',
            'items' => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.comment' => 'nullable|string|max:255',
        ]);

        $order = Order::create([
            'table_id' => $request->table_id,
            'user_id' => Auth::id(),
            'status' => 'pending',
        ]);

        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $item['menu_id'],
                'quantity' => $item['quantity'],
                'comment' => $item['comment'],
            ]);
        }

        return redirect()->route('manager.orders.index')
            ->with('success', 'Commande créée avec succès.');
    }

    /**
     * Display the specified order
     */
    public function show(Order $order)
    {
        $order->load(['table', 'orderItems.menu', 'user']);
        
        return view('manager.orders.show', compact('order'));
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,preparing,served,completed',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Statut de la commande mis à jour.');
    }

    /**
     * Remove the specified order
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('manager.orders.index')
            ->with('success', 'Commande supprimée avec succès.');
    }
}

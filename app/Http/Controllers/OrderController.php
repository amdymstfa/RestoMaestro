<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of orders
     */
    public function index()
    {
        $user = Auth::user();
        
        $query = Order::with(['table', 'items.menuItem', 'waiter']);
        
        if (in_array($user->role, ['manager', 'waiter', 'cook'])) {
            $query->where('restaurant_id', $user->restaurant_id);
        }
        
        $orders = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new order
     */
    public function create()
    {
        $tables = Table::where('status', 'occupied')
            ->orderBy('number')
            ->get();
            
        $menuItems = MenuItem::where('is_available', true)
            ->orderBy('category')
            ->orderBy('name')
            ->get()
            ->groupBy('category');
            
        return view('orders.create', compact('tables', 'menuItems'));
    }

    /**
     * Store a newly created order
     */
    public function store(Request $request)
    {
        $request->validate([
            'table_id' => ['required', 'exists:tables,id'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.menu_item_id' => ['required', 'exists:menu_items,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.special_instructions' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $user = Auth::user();
        
        DB::transaction(function () use ($request, $user) {
            // Calculate total amount
            $totalAmount = 0;
            foreach ($request->items as $item) {
                $menuItem = MenuItem::find($item['menu_item_id']);
                $totalAmount += $menuItem->price * $item['quantity'];
            }

            // Create order
            $order = Order::create([
                'table_id' => $request->table_id,
                'waiter_id' => $user->id,
                'restaurant_id' => $user->restaurant_id,
                'status' => 'pending',
                'total_amount' => $totalAmount,
                'notes' => $request->notes,
            ]);

            // Create order items
            foreach ($request->items as $item) {
                $menuItem = MenuItem::find($item['menu_item_id']);
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $item['menu_item_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $menuItem->price,
                    'special_instructions' => $item['special_instructions'],
                ]);
            }
        });

        return redirect()->route('orders.index')
            ->with('success', 'Commande créée avec succès.');
    }

    /**
     * Display the specified order
     */
    public function show(Order $order)
    {
        $order->load(['table', 'items.menuItem', 'waiter']);
        
        return view('orders.show', compact('order'));
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => ['required', 'in:pending,preparing,ready,served,completed,cancelled'],
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Statut de la commande mis à jour.');
    }

    /**
     * Start preparation (Cook)
     */
    public function startPreparation(Order $order)
    {
        $order->update([
            'status' => 'preparing',
            'preparation_started_at' => now(),
        ]);

        return back()->with('success', 'Préparation commencée.');
    }

    /**
     * Mark order as ready (Cook)
     */
    public function markReady(Order $order)
    {
        $order->update([
            'status' => 'ready',
            'preparation_completed_at' => now(),
        ]);

        return back()->with('success', 'Commande prête à servir.');
    }

    /**
     * Get orders queue for kitchen
     */
    public function queue()
    {
        $user = Auth::user();
        
        $orders = Order::with(['table', 'items.menuItem'])
            ->where('restaurant_id', $user->restaurant_id)
            ->whereIn('status', ['pending', 'preparing'])
            ->orderBy('created_at')
            ->get();
            
        return view('cook.orders-queue', compact('orders'));
    }

    /**
     * Get active orders
     */
    public function active()
    {
        $user = Auth::user();
        
        $query = Order::with(['table', 'items.menuItem', 'waiter'])
            ->whereIn('status', ['pending', 'preparing', 'ready']);
            
        if (in_array($user->role, ['manager', 'waiter', 'cook'])) {
            $query->where('restaurant_id', $user->restaurant_id);
        }
        
        $orders = $query->orderBy('created_at')->get();
        
        return response()->json($orders);
    }

    /**
     * Get order history
     */
    public function history()
    {
        $user = Auth::user();
        
        $query = Order::with(['table', 'items.menuItem', 'waiter'])
            ->whereIn('status', ['served', 'completed', 'cancelled']);
            
        if (in_array($user->role, ['manager', 'waiter', 'cook'])) {
            $query->where('restaurant_id', $user->restaurant_id);
        }
        
        $orders = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('orders.history', compact('orders'));
    }

    /**
     * Get live orders for real-time updates
     */
    public function getLiveOrders()
    {
        $user = Auth::user();
        
        $query = Order::with(['table', 'items.menuItem'])
            ->whereIn('status', ['pending', 'preparing', 'ready']);
            
        if (in_array($user->role, ['manager', 'waiter', 'cook'])) {
            $query->where('restaurant_id', $user->restaurant_id);
        }
        
        $orders = $query->orderBy('created_at')->get();
        
        return response()->json($orders);
    }
}

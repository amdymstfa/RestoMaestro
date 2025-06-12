<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
     * Store a newly created order (compatible avec le formulaire waiter)
     */
    public function store(Request $request)
    {
        try {
            Log::info('Order store request received', [
                'all_data' => $request->all(),
                'table_id' => $request->table_id,
                'selected_items' => $request->selected_items,
                'notes' => $request->notes
            ]);

            // Validation pour le nouveau format
            $request->validate([
                'table_id' => 'required|integer',
                'selected_items' => 'required|string',
                'notes' => 'nullable|string|max:500',
            ]);

            // Décoder les items sélectionnés
            $selectedItems = json_decode($request->selected_items, true);
            
            if (!$selectedItems || !is_array($selectedItems)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Format des items invalide'
                ], 400);
            }

            // Vérifier que la table existe
            $table = Table::find($request->table_id);
            if (!$table) {
                return response()->json([
                    'success' => false,
                    'message' => 'Table non trouvée'
                ], 404);
            }

            // Créer la commande
            $order = Order::create([
                'table_id' => $request->table_id,
                'user_id' => Auth::id(),
                'status' => 'pending',
                'notes' => $request->notes,
                'total_amount' => 0, // Sera calculé après
            ]);

            $totalAmount = 0;

            // Mapping des items du menu avec leurs prix
            $menuPrices = [
                'salade_cesar' => 12.00,
                'soupe_oignon' => 8.00,
                'steak_frites' => 22.00,
                'lasagnes' => 18.00,
                'burger_maison' => 16.00,
                'tiramisu' => 7.00,
                'tarte_pommes' => 6.00,
                'coca_cola' => 3.00,
                'vin_rouge' => 25.00,
            ];

            // Ajouter les items à la commande
            foreach ($selectedItems as $item) {
                $itemName = $item['item'];
                $quantity = (int) $item['quantity'];
                
                if (!isset($menuPrices[$itemName])) {
                    Log::warning('Item non trouvé dans le menu', ['item' => $itemName]);
                    continue;
                }

                $price = $menuPrices[$itemName];
                $subtotal = $price * $quantity;
                $totalAmount += $subtotal;

                // Créer l'item de commande
                OrderItem::create([
                    'order_id' => $order->id,
                    'item_name' => $itemName,
                    'quantity' => $quantity,
                    'unit_price' => $price,
                    'subtotal' => $subtotal,
                ]);
            }

            // Mettre à jour le montant total
            $order->update(['total_amount' => $totalAmount]);

            // Mettre à jour le statut de la table si nécessaire
            if ($table->status === 'available') {
                $table->update(['status' => 'occupied']);
            }

            Log::info('Order created successfully', [
                'order_id' => $order->id,
                'total_amount' => $totalAmount,
                'items_count' => count($selectedItems)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Commande créée avec succès',
                'order_id' => $order->id,
                'total_amount' => $totalAmount
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error in order store', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Error creating order', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de la commande: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified order
     */
    public function show(Order $order)
    {
        $order->load(['table', 'orderItems', 'user']);
        
        return view('manager.orders.show', compact('order'));
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        try {
            Log::info('Updating order status', [
                'order_id' => $order->id,
                'new_status' => $request->status,
                'current_status' => $order->status
            ]);

            $request->validate([
                'status' => 'required|in:pending,preparing,ready,served,completed',
            ]);

            $order->update(['status' => $request->status]);

            Log::info('Order status updated successfully', [
                'order_id' => $order->id,
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Statut mis à jour avec succès'
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating order status', [
                'error' => $e->getMessage(),
                'order_id' => $order->id,
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified order
     */
    public function destroy(Order $order)
    {
        try {
            $order->delete();

            return response()->json([
                'success' => true,
                'message' => 'Commande supprimée avec succès'
            ]);

        } catch (\Exception $e) {
            Log::error('Error deleting order', [
                'error' => $e->getMessage(),
                'order_id' => $order->id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression'
            ], 500);
        }
    }
}
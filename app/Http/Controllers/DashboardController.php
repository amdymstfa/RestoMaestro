<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Table;
use App\Models\Reservation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use App\Models\Log;

class DashboardController extends Controller
{
    /**
     * Redirect to appropriate dashboard based on user role
     */
    public function index()
    {
        $user = Auth::user();
        
        return match($user->role) {
            'manager' => redirect()->route('manager.dashboard'),
            'waiter' => redirect()->route('waiter.dashboard'),
            'cook' => redirect()->route('cook.dashboard'),
            'client' => redirect()->route('client.dashboard'),
            default => abort(403, 'Unauthorized role')
        };
    }

    /**
     * Manager Dashboard with real data
     */
    public function manager()
    {
        $today = Carbon::today();
        
        // Statistiques du jour
        $stats = [
            'clients_today' => $this->getClientsToday($today),
            'revenue_today' => $this->getRevenueToday($today),
            'reservations_count' => $this->getReservationsToday($today),
            'occupied_tables' => $this->getTablesOccupancy()['occupied'],
            'total_tables' => $this->getTablesOccupancy()['total'],
            'tables_occupancy_rate' => $this->getTablesOccupancy()['percentage'],
        ];
        
        // Réservations du jour
        $todayReservations = Reservation::whereDate('reservation_time', $today)
            ->with('table')
            ->orderBy('reservation_time')
            ->get()
            ->map(function ($reservation) {
                return [
                    'id' => $reservation->id,
                    'client' => $reservation->client_name,
                    'time' => Carbon::parse($reservation->reservation_time)->format('H:i'),
                    'guests' => $reservation->guests ?? 'N/A',
                    'table' => $reservation->table ? $reservation->table->number : 'Non assignée',
                    'status' => $this->getReservationStatus($reservation),
                    'phone' => $reservation->phone,
                ];
            });
        
        // Activité récente
        $recentActivity = Log::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($log) {
                return [
                    'type' => $log->action_type,
                    'message' => $this->formatLogMessage($log),
                    'time' => $log->created_at->diffForHumans(),
                    'icon' => $this->getLogIcon($log->action_type),
                    'icon_color' => $this->getLogIconColor($log->action_type),
                    'icon_bg' => $this->getLogIconBg($log->action_type),
                ];
            });
        
        // Tables avec leur statut et position pour le plan de salle
        $tables = Table::orderBy('number')->get()->map(function ($table, $index) {
            return [
                'id' => $table->id,
                'number' => $table->number,
                'seats' => $table->seats,
                'status' => $table->status,
                'status_label' => $this->getTableStatusLabel($table->status),
                'position' => $this->getTablePosition($index), // Position pour le plan de salle
                'shape' => $table->seats > 4 ? 'rectangle' : 'round', // Forme basée sur le nombre de places
                'current_order' => $this->getCurrentTableOrder($table->id),
            ];
        });
        
        return view('dashboard.manager', compact('stats', 'todayReservations', 'recentActivity', 'tables'));
    }

    /**
     * Waiter Dashboard with REAL data from database
     */
    public function waiter()
    {
        $today = Carbon::today();
        $now = Carbon::now();
        
        // Tables avec statut réel depuis la base de données
        $tables = Table::orderBy('number')->get()->map(function ($table) use ($now) {
            $currentOrder = $this->getCurrentTableOrder($table->id);
            $occupiedSince = null;
            $reservationTime = null;
            
            // Si la table est occupée, calculer depuis quand
            if ($table->status === 'occupied' && $currentOrder) {
                $occupiedSince = $currentOrder->created_at->diffForHumans();
            }
            
            // Si la table est réservée, récupérer l'heure de réservation
            if ($table->status === 'reserved') {
                $reservation = Reservation::where('table_id', $table->id)
                    ->where('reservation_time', '>', $now)
                    ->orderBy('reservation_time')
                    ->first();
                if ($reservation) {
                    $reservationTime = Carbon::parse($reservation->reservation_time)->format('H:i');
                }
            }
            
            return [
                'id' => $table->id,
                'number' => $table->number,
                'capacity' => $table->seats,
                'status' => $this->mapTableStatusForWaiter($table->status),
                'occupied_since' => $occupiedSince,
                'reservation_time' => $reservationTime,
            ];
        });
        
        // Commandes actives depuis la base de données
        $activeOrders = Order::whereIn('status', ['pending', 'preparing', 'served'])
            ->with(['table', 'orderItems.menuItem'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($order) {
                $items = $order->orderItems->map(function ($item) {
                    return $item->quantity . 'x ' . $item->menuItem->name;
                })->toArray();
                
                return [
                    'id' => $order->id,
                    'table' => $order->table->number,
                    'items' => $items,
                    'time' => $order->created_at->format('H:i'),
                    'status' => $order->status,
                    'notes' => $order->notes ?? '',
                ];
            });
        
        // Réservations à venir depuis la base de données
        $upcomingReservations = Reservation::where('reservation_time', '>', $now)
            ->whereDate('reservation_time', $today)
            ->with('table')
            ->orderBy('reservation_time')
            ->get()
            ->map(function ($reservation) {
                return [
                    'client' => $reservation->client_name,
                    'guests' => $reservation->guests,
                    'time' => Carbon::parse($reservation->reservation_time)->format('H:i'),
                    'table' => $reservation->table ? $reservation->table->number : 'À attribuer',
                ];
            });
        
        return view('dashboard.waiter', compact('tables', 'activeOrders', 'upcomingReservations'));
    }

    /**
     * Cook Dashboard with REAL data from database
     */
    public function cook()
    {
        // Statistiques des commandes depuis la base de données
        $orderStats = [
            'pending' => Order::where('status', 'pending')->count(),
            'preparing' => Order::where('status', 'preparing')->count(),
            'ready' => Order::where('status', 'ready')->count(),
        ];
        
        // File d'attente des commandes depuis la base de données
        $ordersQueue = Order::whereIn('status', ['pending', 'preparing'])
            ->with(['table', 'orderItems.menuItem'])
            ->orderBy('created_at')
            ->get()
            ->map(function ($order) {
                $items = $order->orderItems->map(function ($item) {
                    return $item->quantity . 'x ' . $item->menuItem->name;
                })->toArray();
                
                $duration = $order->status === 'pending' ? 'Nouveau' : $order->created_at->diffForHumans();
                
                return [
                    'id' => $order->id,
                    'table' => $order->table->number,
                    'items' => $items,
                    'time' => $order->created_at->format('H:i'),
                    'status' => $order->status,
                    'notes' => $order->notes ?? '',
                    'duration' => $duration,
                ];
            });
        
        // Commandes prêtes depuis la base de données
        $readyOrders = Order::where('status', 'ready')
            ->with(['table', 'orderItems.menuItem'])
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function ($order) {
                $items = $order->orderItems->map(function ($item) {
                    return $item->quantity . 'x ' . $item->menuItem->name;
                })->toArray();
                
                return [
                    'id' => $order->id,
                    'table' => $order->table->number,
                    'items' => $items,
                    'ready_since' => $order->updated_at->diffForHumans(),
                ];
            });
        
        // Alertes de stock (pour l'instant statique, à connecter plus tard à un système de stock)
        $lowStockItems = [
            ['name' => 'Vin rouge - Bordeaux', 'current_stock' => 2, 'unit' => 'bouteilles', 'level' => 'critical'],
            ['name' => 'Champignons frais', 'current_stock' => 300, 'unit' => 'g', 'level' => 'critical'],
            ['name' => 'Crème fraîche', 'current_stock' => 500, 'unit' => 'ml', 'level' => 'warning'],
        ];
        
        return view('dashboard.cook', compact('orderStats', 'ordersQueue', 'readyOrders', 'lowStockItems'));
    }

    /**
     * Client Dashboard
     */
    public function client()
    {
        $user = Auth::user();
        
        // Statistiques du client depuis la base de données
        $stats = [
            'upcoming_reservations' => Reservation::where('client_name', $user->name)
                ->where('reservation_time', '>', Carbon::now())
                ->count(),
            'past_visits' => Reservation::where('client_name', $user->name)
                ->where('reservation_time', '<', Carbon::now())
                ->count(),
            'loyalty_points' => 250, // À connecter à un système de fidélité
        ];
        
        // Prochaine réservation depuis la base de données
        $nextReservation = Reservation::where('client_name', $user->name)
            ->where('reservation_time', '>', Carbon::now())
            ->orderBy('reservation_time')
            ->first();
            
        $nextReservationData = null;
        if ($nextReservation) {
            $nextReservationData = [
                'date' => Carbon::parse($nextReservation->reservation_time)->format('d M Y'),
                'time' => Carbon::parse($nextReservation->reservation_time)->format('H:i'),
                'guests' => $nextReservation->guests,
                'notes' => $nextReservation->notes ?? 'Aucune note spéciale'
            ];
        }
        
        // Menu dynamique depuis la base de données
        $entrees = Menu::where('category', 'entrée')->where('is_available', true)->get();
        $plats = Menu::where('category', 'plat')->where('is_available', true)->get();
        $desserts = Menu::where('category', 'dessert')->where('is_available', true)->get();
        $boissons = Menu::where('category', 'boisson')->where('is_available', true)->get();
        
        $menuPreview = [
            'entrees' => $entrees,
            'plats' => $plats,
            'desserts' => $desserts,
            'boissons' => $boissons
        ];
        
        return view('dashboard.client', compact('stats', 'nextReservationData', 'menuPreview'));
    }

    /**
     * Map table status for waiter interface
     */
    private function mapTableStatusForWaiter($status)
    {
        return match($status) {
            'free' => 'available',
            'occupied' => 'occupied',
            'reserved' => 'reserved',
            default => 'available'
        };
    }

    // ... (toutes les autres méthodes privées restent identiques)
    
    /**
     * Get clients count for today
     */
    private function getClientsToday($today)
    {
        return Reservation::whereDate('reservation_time', $today)->count();
    }

    /**
     * Get revenue for today
     */
    private function getRevenueToday($today)
    {
        $revenue = Order::whereDate('orders.created_at', $today)
            ->where('orders.status', 'completed')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('menu_items', 'order_items.menu_id', '=', 'menu_items.id')
            ->sum(DB::raw('order_items.quantity * menu_items.price'));
            
        return $revenue ?? 0;
    }

    /**
     * Get reservations count for today
     */
    private function getReservationsToday($today)
    {
        return Reservation::whereDate('reservation_time', $today)->count();
    }

    /**
     * Get tables occupancy
     */
    private function getTablesOccupancy()
    {
        $total = Table::count();
        $occupied = Table::where('status', 'occupied')->count();
        
        return [
            'occupied' => $occupied,
            'total' => $total,
            'percentage' => $total > 0 ? round(($occupied / $total) * 100) : 0
        ];
    }

    /**
     * Get reservation status
     */
    private function getReservationStatus($reservation)
    {
        $now = Carbon::now();
        $reservationTime = Carbon::parse($reservation->reservation_time);
        
        if ($reservationTime->isPast()) {
            return 'completed';
        } elseif ($reservationTime->diffInHours($now) <= 1) {
            return 'upcoming';
        } else {
            return 'confirmed';
        }
    }

    /**
     * Format log message
     */
    private function formatLogMessage($log)
    {
        $user = $log->user ? $log->user->name : 'Système';
        
        return match($log->action_type) {
            'order_completed' => "Commande #{$log->details} terminée",
            'reservation_created' => "Nouvelle réservation par {$user}",
            'table_status_changed' => "Statut table modifié: {$log->details}",
            'user_login' => "{$user} s'est connecté",
            'user_logout' => "{$user} s'est déconnecté",
            default => $log->details ?? $log->action_type
        };
    }

    /**
     * Get log icon
     */
    private function getLogIcon($actionType)
    {
        return match($actionType) {
            'order_completed' => 'fas fa-check',
            'reservation_created' => 'fas fa-user-plus',
            'table_status_changed' => 'fas fa-utensils',
            'user_login' => 'fas fa-sign-in-alt',
            'user_logout' => 'fas fa-sign-out-alt',
            default => 'fas fa-info'
        };
    }

    /**
     * Get log icon color
     */
    private function getLogIconColor($actionType)
    {
        return match($actionType) {
            'order_completed' => 'text-green-600',
            'reservation_created' => 'text-blue-600',
            'table_status_changed' => 'text-yellow-600',
            'user_login' => 'text-green-600',
            'user_logout' => 'text-gray-600',
            default => 'text-blue-600'
        };
    }

    /**
     * Get log icon background
     */
    private function getLogIconBg($actionType)
    {
        return match($actionType) {
            'order_completed' => 'bg-green-100',
            'reservation_created' => 'bg-blue-100',
            'table_status_changed' => 'bg-yellow-100',
            'user_login' => 'bg-green-100',
            'user_logout' => 'bg-gray-100',
            default => 'bg-blue-100'
        };
    }

    /**
     * Get table status label
     */
    private function getTableStatusLabel($status)
    {
        return match($status) {
            'free' => 'Libre',
            'occupied' => 'Occupée',
            'reserved' => 'Réservée',
            default => 'Inconnu'
        };
    }

    /**
     * Get table position for floor plan
     */
    private function getTablePosition($index)
    {
        // Positions prédéfinies pour un plan de salle simple
        $positions = [
            'top-10 left-10',
            'top-10 left-40',
            'top-10 right-40',
            'top-10 right-10',
            'top-40 left-20',
            'top-40 left-60',
            'top-40 right-20',
            'bottom-20 left-10',
            'bottom-20 left-40',
            'bottom-20 right-40',
            'bottom-20 right-11',
        ];
        
        return $positions[$index] ?? 'top-10 left-10';
    }

    /**
     * Get current order for a table
     */
    private function getCurrentTableOrder($tableId)
    {
        return Order::where('table_id', $tableId)
            ->whereIn('status', ['pending', 'preparing', 'served'])
            ->with('orderItems.menuItem')
            ->first();
    }
}
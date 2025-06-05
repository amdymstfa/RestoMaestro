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
            'bottom-20 right-10',
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

    /**
     * Waiter Dashboard
     */
    public function waiter()
    {
        // Mock data for tables
        $tables = [
            ['id' => 1, 'number' => 1, 'capacity' => 4, 'status' => 'available'],
            ['id' => 2, 'number' => 2, 'capacity' => 2, 'status' => 'occupied', 'occupied_since' => '45 min'],
            ['id' => 3, 'number' => 3, 'capacity' => 6, 'status' => 'occupied', 'occupied_since' => '15 min'],
            ['id' => 4, 'number' => 4, 'capacity' => 4, 'status' => 'reserved', 'reservation_time' => '13:30'],
            ['id' => 5, 'number' => 5, 'capacity' => 2, 'status' => 'available'],
            ['id' => 6, 'number' => 6, 'capacity' => 4, 'status' => 'occupied', 'occupied_since' => '30 min'],
            ['id' => 7, 'number' => 7, 'capacity' => 2, 'status' => 'available'],
            ['id' => 8, 'number' => 8, 'capacity' => 8, 'status' => 'reserved', 'reservation_time' => '20:00'],
        ];
        
        $activeOrders = [
            ['id' => 1245, 'table' => 2, 'items' => ['2x Salade César', '1x Lasagnes', '1x Tiramisu'], 'time' => '12:15', 'status' => 'preparing', 'notes' => 'Sans oignons pour les salades'],
            ['id' => 1246, 'table' => 3, 'items' => ['4x Steak frites', '2x Soupe à l\'oignon'], 'time' => '12:30', 'status' => 'preparing', 'notes' => '2 steaks bien cuits, 2 à point'],
            ['id' => 1247, 'table' => 6, 'items' => ['2x Burger maison', '2x Frites', '2x Coca-Cola'], 'time' => '12:45', 'status' => 'served'],
        ];
        
        $upcomingReservations = [
            ['client' => 'Martin Dubois', 'guests' => 4, 'time' => '13:30', 'table' => 4],
            ['client' => 'Famille Petit', 'guests' => 8, 'time' => '20:00', 'table' => 8],
            ['client' => 'Julie Blanc', 'guests' => 2, 'time' => '20:30', 'table' => 'À attribuer'],
        ];
        
        return view('dashboard.waiter', compact('tables', 'activeOrders', 'upcomingReservations'));
    }

    /**
     * Cook Dashboard
     */
    public function cook()
    {
        $orderStats = [
            'pending' => 4,
            'preparing' => 2,
            'ready' => 3,
        ];
        
        $ordersQueue = [
            ['id' => 1245, 'table' => 2, 'items' => ['2x Salade César', '1x Lasagnes', '1x Tiramisu'], 'time' => '12:15', 'status' => 'preparing', 'notes' => 'Sans oignons pour les salades', 'duration' => '20 min'],
            ['id' => 1246, 'table' => 3, 'items' => ['4x Steak frites', '2x Soupe à l\'oignon'], 'time' => '12:30', 'status' => 'preparing', 'notes' => '2 steaks bien cuits, 2 à point', 'duration' => '5 min'],
            ['id' => 1247, 'table' => 5, 'items' => ['1x Risotto aux champignons', '1x Poulet rôti'], 'time' => '12:40', 'status' => 'pending', 'notes' => '', 'duration' => 'Nouveau'],
            ['id' => 1248, 'table' => 7, 'items' => ['2x Salade niçoise', '2x Crème brûlée'], 'time' => '12:42', 'status' => 'pending', 'notes' => '', 'duration' => 'Nouveau'],
        ];
        
        $readyOrders = [
            ['id' => 1242, 'table' => 1, 'items' => ['2x Quiche Lorraine', '2x Salade verte'], 'ready_since' => '5 min'],
            ['id' => 1243, 'table' => 4, 'items' => ['1x Bœuf bourguignon', '1x Tarte aux pommes'], 'ready_since' => '3 min'],
            ['id' => 1244, 'table' => 8, 'items' => ['3x Magret de canard', '3x Mousse au chocolat'], 'ready_since' => '1 min'],
        ];
        
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
        
        // Statistiques du client (à dynamiser plus tard)
        $stats = [
            'upcoming_reservations' => 1,
            'past_visits' => 8,
            'loyalty_points' => 250,
        ];
        
        // Prochaine réservation (à dynamiser plus tard)
        $nextReservation = [
            'date' => '15 juin 2024',
            'time' => '20:00',
            'guests' => 2,
            'notes' => 'Table près de la fenêtre demandée'
        ];
        
        // Menu dynamique depuis la base de données
        $entrees = Menu::where('type', 'entrée')->get();
        $plats = Menu::where('type', 'plat')->get();
        $desserts = Menu::where('type', 'dessert')->get();
        $boissons = Menu::where('type', 'boisson')->get();
        
        $menuPreview = [
            'entrees' => $entrees,
            'plats' => $plats,
            'desserts' => $desserts,
            'boissons' => $boissons
        ];
        
        return view('dashboard.client', compact('stats', 'nextReservation', 'menuPreview'));
    }
}

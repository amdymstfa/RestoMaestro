<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
     * Manager Dashboard
     */
    public function manager()
    {
        $stats = [
            'clients_today' => 78,
            'revenue_today' => 2450,
            'reservations_today' => 24,
            'tables_occupied' => ['occupied' => 12, 'total' => 20],
        ];
        
        // Mock data for now
        $todayReservations = [
            ['client' => 'Martin Dubois', 'time' => '12:30', 'guests' => 4, 'table' => 8, 'status' => 'confirmed'],
            ['client' => 'Sophie Martin', 'time' => '13:00', 'guests' => 2, 'table' => 5, 'status' => 'confirmed'],
            ['client' => 'Pierre Lemoine', 'time' => '19:30', 'guests' => 6, 'table' => 12, 'status' => 'pending'],
            ['client' => 'Julie Blanc', 'time' => '20:00', 'guests' => 3, 'table' => 7, 'status' => 'confirmed'],
        ];
        
        $recentActivity = [
            ['type' => 'order', 'message' => 'Commande #1234 terminée', 'time' => '10 minutes', 'icon' => 'check', 'color' => 'green'],
            ['type' => 'reservation', 'message' => 'Nouvelle réservation', 'time' => '25 minutes', 'icon' => 'user-plus', 'color' => 'blue'],
            ['type' => 'alert', 'message' => 'Stock faible: Vin rouge', 'time' => '1 heure', 'icon' => 'exclamation', 'color' => 'yellow'],
            ['type' => 'cancellation', 'message' => 'Annulation réservation #45', 'time' => '2 heures', 'icon' => 'times', 'color' => 'red'],
        ];
        
        return view('dashboard.manager', compact('stats', 'todayReservations', 'recentActivity'));
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
        
        $stats = [
            'upcoming_reservations' => 1,
            'past_visits' => 8,
            'loyalty_points' => 250,
        ];
        
        $nextReservation = [
            'date' => '15 juin 2024',
            'time' => '20:00',
            'guests' => 2,
            'notes' => 'Table près de la fenêtre demandée'
        ];
        
        $menuPreview = [
            'entrees' => [
                ['name' => 'Salade César', 'price' => 9, 'description' => 'Laitue romaine, parmesan, croûtons, sauce César'],
                ['name' => 'Soupe à l\'oignon', 'price' => 8, 'description' => 'Oignons caramélisés, bouillon, croûtons, gruyère'],
                ['name' => 'Foie gras maison', 'price' => 15, 'description' => 'Foie gras de canard, chutney de figues, pain toasté'],
            ],
            'plats' => [
                ['name' => 'Steak frites', 'price' => 22, 'description' => 'Entrecôte grillée, frites maison, sauce béarnaise'],
                ['name' => 'Risotto aux champignons', 'price' => 18, 'description' => 'Riz arborio, champignons, parmesan, truffe'],
                ['name' => 'Filet de bar', 'price' => 24, 'description' => 'Filet de bar grillé, légumes de saison, sauce vierge'],
            ],
            'desserts' => [
                ['name' => 'Tiramisu', 'price' => 8, 'description' => 'Mascarpone, café, biscuits, cacao'],
                ['name' => 'Crème brûlée', 'price' => 7, 'description' => 'Crème vanillée, caramel'],
                ['name' => 'Tarte aux fruits', 'price' => 9, 'description' => 'Pâte sablée, crème pâtissière, fruits de saison'],
            ],
        ];
        
        return view('dashboard.client', compact('stats', 'nextReservation', 'menuPreview'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display reports dashboard
     */
    public function index()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        
        // Statistiques générales
        $stats = [
            'total_orders_today' => Order::whereDate('created_at', $today)->count(),
            'total_revenue_today' => $this->calculateRevenue($today, $today),
            'total_reservations_today' => Reservation::whereDate('reservation_time', $today)->count(),
            'total_revenue_month' => $this->calculateRevenue($thisMonth, Carbon::now()),
        ];
        
        return view('manager.reports.index', compact('stats'));
    }

    /**
     * Sales report
     */
    public function sales(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        
        $salesData = Order::whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.status', 'completed')
            ->with('orderItems.menuItem')
            ->get();
            
        $totalRevenue = $this->calculateRevenue($startDate, $endDate);
        $totalOrders = $salesData->count();
        
        return view('manager.reports.sales', compact('salesData', 'totalRevenue', 'totalOrders', 'startDate', 'endDate'));
    }

    /**
     * Reservations report
     */
    public function reservations(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        
        $reservationsData = Reservation::whereBetween('reservation_time', [$startDate, $endDate])
            ->with('table')
            ->get();
            
        $totalReservations = $reservationsData->count();
        
        return view('manager.reports.reservations', compact('reservationsData', 'totalReservations', 'startDate', 'endDate'));
    }

    /**
     * Staff performance report
     */
    public function staffPerformance(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        
        $staffPerformance = User::where('role', '!=', 'client')
            ->withCount(['orders' => function($query) use ($startDate, $endDate) {
                $query->whereBetween('orders.created_at', [$startDate, $endDate]);
            }])
            ->get();
            
        return view('manager.reports.staff-performance', compact('staffPerformance', 'startDate', 'endDate'));
    }

    /**
     * Calculate revenue for a date range
     */
    private function calculateRevenue($startDate, $endDate)
    {
        return Order::whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.status', 'completed')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('menu_items', 'order_items.menu_id', '=', 'menu_items.id')
            ->sum(DB::raw('order_items.quantity * menu_items.price')) ?? 0;
    }
}

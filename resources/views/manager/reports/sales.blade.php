@extends('layouts.manager')

@section('title', 'Rapport des Ventes')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Rapport des Ventes</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('manager.reports.index') }}">Rapports</a></li>
        <li class="breadcrumb-item active">Ventes</li>
    </ol>

    <!-- Filtres -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-filter me-1"></i>
            Filtres
        </div>
        <div class="card-body">
            <form action="{{ route('manager.reports.sales') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="start_date" class="form-label">Date de début</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate }}">
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">Date de fin</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Filtrer</button>
                    <a href="{{ route('manager.reports.sales') }}" class="btn btn-secondary ms-2">Réinitialiser</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistiques générales -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small">Total des commandes</div>
                            <div class="fs-4">{{ $totalOrders }}</div>
                        </div>
                        <div>
                            <i class="fas fa-shopping-cart fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small">Chiffre d'affaires</div>
                            <div class="fs-4">{{ number_format($totalRevenue, 2, ',', ' ') }} €</div>
                        </div>
                        <div>
                            <i class="fas fa-euro-sign fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small">Panier moyen</div>
                            <div class="fs-4">
                                {{ $totalOrders > 0 ? number_format($totalRevenue / $totalOrders, 2, ',', ' ') : '0,00' }} €
                            </div>
                        </div>
                        <div>
                            <i class="fas fa-calculator fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small">Période</div>
                            <div class="small">{{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</div>
                        </div>
                        <div>
                            <i class="fas fa-calendar-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphique des ventes -->
    <div class="row">
        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-line me-1"></i>
                    Évolution des ventes
                </div>
                <div class="card-body">
                    <canvas id="salesChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-1"></i>
                    Répartition par type de plat
                </div>
                <div class="card-body">
                    <canvas id="menuTypeChart" width="100%" height="50"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Top des plats -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-trophy me-1"></i>
            Top des plats les plus vendus
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Rang</th>
                            <th>Plat</th>
                            <th>Type</th>
                            <th>Quantité vendue</th>
                            <th>Chiffre d'affaires</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $topItems = collect();
                            foreach ($salesData as $order) {
                                foreach ($order->orderItems as $item) {
                                    if ($item->menuItem) {
                                        $menuId = $item->menuItem->id;
                                        if (!$topItems->has($menuId)) {
                                            $topItems[$menuId] = [
                                                'name' => $item->menuItem->name,
                                                'type' => $item->menuItem->type,
                                                'quantity' => 0,
                                                'revenue' => 0
                                            ];
                                        }
                                        $topItems[$menuId]['quantity'] += $item->quantity;
                                        $topItems[$menuId]['revenue'] += $item->quantity * $item->menuItem->price;
                                    }
                                }
                            }
                            $topItems = $topItems->sortByDesc('quantity')->take(10);
                        @endphp

                        @foreach ($topItems as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['type'] }}</td>
                                <td>{{ $item['quantity'] }}</td>
                                <td>{{ number_format($item['revenue'], 2, ',', ' ') }} €</td>
                            </tr>
                        @endforeach

                        @if ($topItems->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center">Aucune donnée disponible pour cette période</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Détail des commandes -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-list me-1"></i>
            Détail des commandes
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Table</th>
                            <th>Serveur</th>
                            <th>Statut</th>
                            <th>Montant</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($salesData as $order)
                            @php
                                $orderTotal = 0;
                                foreach ($order->orderItems as $item) {
                                    if ($item->menuItem) {
                                        $orderTotal += $item->quantity * $item->menuItem->price;
                                    }
                                }
                            @endphp
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $order->table ? 'Table ' . $order->table->number : 'N/A' }}</td>
                                <td>{{ $order->user ? $order->user->name : 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-{{ $order->status == 'completed' ? 'success' : 'warning' }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td>{{ number_format($orderTotal, 2, ',', ' ') }} €</td>
                                <td>
                                    <a href="{{ route('manager.orders.show', $order->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                        @if ($salesData->isEmpty())
                            <tr>
                                <td colspan="7" class="text-center">Aucune commande pour cette période</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Données pour le graphique des ventes
        const salesData = @json($salesData);
        const startDate = new Date('{{ $startDate }}');
        const endDate = new Date('{{ $endDate }}');
        
        // Créer un tableau de dates entre start et end
        const dateRange = [];
        const currentDate = new Date(startDate);
        while (currentDate <= endDate) {
            dateRange.push(new Date(currentDate));
            currentDate.setDate(currentDate.getDate() + 1);
        }
        
        // Formater les dates pour l'affichage
        const labels = dateRange.map(date => {
            return date.toLocaleDateString('fr-FR', { day: '2-digit', month: '2-digit' });
        });
        
        // Calculer les ventes par jour
        const salesByDay = {};
        dateRange.forEach(date => {
            const dateString = date.toISOString().split('T')[0];
            salesByDay[dateString] = 0;
        });
        
        salesData.forEach(order => {
            const orderDate = order.created_at.split(' ')[0];
            let orderTotal = 0;
            order.order_items.forEach(item => {
                if (item.menu_item) {
                    orderTotal += item.quantity * item.menu_item.price;
                }
            });
            
            if (salesByDay[orderDate] !== undefined) {
                salesByDay[orderDate] += orderTotal;
            }
        });
        
        const salesValues = Object.values(salesByDay);
        
        // Graphique des ventes
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Chiffre d\'affaires (€)',
                    data: salesValues,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value + ' €';
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.raw + ' €';
                            }
                        }
                    }
                }
            }
        });
        
        // Données pour le graphique par type de plat
        const menuTypes = {};
        salesData.forEach(order => {
            order.order_items.forEach(item => {
                if (item.menu_item) {
                    const type = item.menu_item.type;
                    if (!menuTypes[type]) {
                        menuTypes[type] = 0;
                    }
                    menuTypes[type] += item.quantity;
                }
            });
        });
        
        const typeLabels = Object.keys(menuTypes);
        const typeValues = Object.values(menuTypes);
        const backgroundColors = [
            'rgba(255, 99, 132, 0.7)',
            'rgba(54, 162, 235, 0.7)',
            'rgba(255, 206, 86, 0.7)',
            'rgba(75, 192, 192, 0.7)'
        ];
        
        // Graphique par type de plat
        const typeCtx = document.getElementById('menuTypeChart').getContext('2d');
        new Chart(typeCtx, {
            type: 'pie',
            data: {
                labels: typeLabels,
                datasets: [{
                    data: typeValues,
                    backgroundColor: backgroundColors,
                    borderColor: 'white',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection

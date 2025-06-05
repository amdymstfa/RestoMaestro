@extends('layouts.manager')

@section('title', 'Performance du Personnel')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Performance du Personnel</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('manager.reports.index') }}">Rapports</a></li>
        <li class="breadcrumb-item active">Performance du Personnel</li>
    </ol>

    <!-- Filtres -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-filter me-1"></i>
            Filtres
        </div>
        <div class="card-body">
            <form action="{{ route('manager.reports.staff-performance') }}" method="GET" class="row g-3">
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
                    <a href="{{ route('manager.reports.staff-performance') }}" class="btn btn-secondary ms-2">Réinitialiser</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Commandes traitées par employé
                </div>
                <div class="card-body">
                    <canvas id="ordersByStaffChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-1"></i>
                    Répartition par rôle
                </div>
                <div class="card-body">
                    <canvas id="staffByRoleChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau de performance -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Performance du personnel
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Employé</th>
                            <th>Rôle</th>
                            <th>Commandes traitées</th>
                            <th>Performance</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $maxOrders = $staffPerformance->max('orders_count') ?: 1;
                        @endphp
                        
                        @foreach ($staffPerformance as $staff)
                            @php
                                $performancePercentage = ($staff->orders_count / $maxOrders) * 100;
                                $performanceClass = 'bg-danger';
                                
                                if ($performancePercentage >= 80) {
                                    $performanceClass = 'bg-success';
                                } elseif ($performancePercentage >= 50) {
                                    $performanceClass = 'bg-warning';
                                }
                            @endphp
                            
                            <tr>
                                <td>{{ $staff->name }}</td>
                                <td>
                                    <span class="badge bg-{{ 
                                        $staff->role == 'manager' ? 'primary' : 
                                        ($staff->role == 'waiter' ? 'info' : 'secondary') 
                                    }}">
                                        {{ ucfirst($staff->role) }}
                                    </span>
                                </td>
                                <td>{{ $staff->orders_count }}</td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar {{ $performanceClass }}" role="progressbar" 
                                            style="width: {{ $performancePercentage }}%" 
                                            aria-valuenow="{{ $performancePercentage }}" 
                                            aria-valuemin="0" 
                                            aria-valuemax="100">
                                            {{ round($performancePercentage) }}%
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('manager.staff.show', $staff->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                        @if ($staffPerformance->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center">Aucune donnée disponible pour cette période</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Statistiques détaillées -->
    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-line me-1"></i>
                    Performance par jour
                </div>
                <div class="card-body">
                    <canvas id="performanceByDayChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-award me-1"></i>
                    Top Performers
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Rang</th>
                                    <th>Employé</th>
                                    <th>Rôle</th>
                                    <th>Commandes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($staffPerformance->sortByDesc('orders_count')->take(5) as $index => $staff)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $staff->name }}</td>
                                        <td>{{ ucfirst($staff->role) }}</td>
                                        <td>{{ $staff->orders_count }}</td>
                                    </tr>
                                @endforeach

                                @if ($staffPerformance->isEmpty())
                                    <tr>
                                        <td colspan="4" class="text-center">Aucune donnée disponible</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Données pour les graphiques
        const staffData = @json($staffPerformance);
        
        // Commandes par employé
        const staffNames = staffData.map(staff => staff.name);
        const orderCounts = staffData.map(staff => staff.orders_count);
        const roleColors = staffData.map(staff => {
            switch(staff.role) {
                case 'manager': return 'rgba(0, 123, 255, 0.7)';
                case 'waiter': return 'rgba(23, 162, 184, 0.7)';
                case 'cook': return 'rgba(108, 117, 125, 0.7)';
                default: return 'rgba(0, 0, 0, 0.7)';
            }
        });
        
        const ordersByStaffCtx = document.getElementById('ordersByStaffChart').getContext('2d');
        new Chart(ordersByStaffCtx, {
            type: 'bar',
            data: {
                labels: staffNames,
                datasets: [{
                    label: 'Commandes traitées',
                    data: orderCounts,
                    backgroundColor: roleColors,
                    borderColor: roleColors.map(color => color.replace('0.7', '1')),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
        
        // Répartition par rôle
        const roleCounts = {
            'manager': 0,
            'waiter': 0,
            'cook': 0
        };
        
        staffData.forEach(staff => {
            if (roleCounts[staff.role] !== undefined) {
                roleCounts[staff.role]++;
            }
        });
        
        const roleLabels = ['Managers', 'Serveurs', 'Cuisiniers'];
        const roleValues = [roleCounts.manager, roleCounts.waiter, roleCounts.cook];
        const roleChartColors = [
            'rgba(0, 123, 255, 0.7)',
            'rgba(23, 162, 184, 0.7)',
            'rgba(108, 117, 125, 0.7)'
        ];
        
        const staffByRoleCtx = document.getElementById('staffByRoleChart').getContext('2d');
        new Chart(staffByRoleCtx, {
            type: 'pie',
            data: {
                labels: roleLabels,
                datasets: [{
                    data: roleValues,
                    backgroundColor: roleChartColors,
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
        
        // Performance par jour (données simulées)
        const days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
        
        // Simuler des données pour chaque employé
        const performanceData = [];
        const topStaff = staffData.sort((a, b) => b.orders_count - a.orders_count).slice(0, 3);
        
        topStaff.forEach(staff => {
            const dailyData = days.map(() => Math.floor(Math.random() * 10) + 1);
            
            performanceData.push({
                label: staff.name,
                data: dailyData,
                borderColor: staff.role === 'manager' ? 'rgba(0, 123, 255, 1)' : 
                             (staff.role === 'waiter' ? 'rgba(23, 162, 184, 1)' : 'rgba(108, 117, 125, 1)'),
                backgroundColor: 'transparent',
                borderWidth: 2,
                tension: 0.1
            });
        });
        
        const performanceByDayCtx = document.getElementById('performanceByDayChart').getContext('2d');
        new Chart(performanceByDayCtx, {
            type: 'line',
            data: {
                labels: days,
                datasets: performanceData
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    });
</script>
@endsection

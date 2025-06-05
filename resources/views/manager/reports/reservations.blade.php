@extends('layouts.manager')

@section('title', 'Rapport des Réservations')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Rapport des Réservations</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('manager.reports.index') }}">Rapports</a></li>
        <li class="breadcrumb-item active">Réservations</li>
    </ol>

    <!-- Filtres -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-filter me-1"></i>
            Filtres
        </div>
        <div class="card-body">
            <form action="{{ route('manager.reports.reservations') }}" method="GET" class="row g-3">
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
                    <a href="{{ route('manager.reports.reservations') }}" class="btn btn-secondary ms-2">Réinitialiser</a>
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
                            <div class="small">Total des réservations</div>
                            <div class="fs-4">{{ $totalReservations }}</div>
                        </div>
                        <div>
                            <i class="fas fa-calendar-check fa-2x"></i>
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
                            <div class="small">Réservations confirmées</div>
                            <div class="fs-4">{{ $reservationsData->where('status', 'confirmed')->count() }}</div>
                        </div>
                        <div>
                            <i class="fas fa-check-circle fa-2x"></i>
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
                            <div class="small">Réservations en attente</div>
                            <div class="fs-4">{{ $reservationsData->where('status', 'pending')->count() }}</div>
                        </div>
                        <div>
                            <i class="fas fa-clock fa-2x"></i>
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
                            <div class="small">Réservations annulées</div>
                            <div class="fs-4">{{ $reservationsData->where('status', 'cancelled')->count() }}</div>
                        </div>
                        <div>
                            <i class="fas fa-times-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Réservations par jour
                </div>
                <div class="card-body">
                    <canvas id="reservationsByDayChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-1"></i>
                    Réservations par statut
                </div>
                <div class="card-body">
                    <canvas id="reservationsByStatusChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-line me-1"></i>
                    Réservations par heure
                </div>
                <div class="card-body">
                    <canvas id="reservationsByHourChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Réservations par taille de groupe
                </div>
                <div class="card-body">
                    <canvas id="reservationsByGroupSizeChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des réservations -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-list me-1"></i>
            Liste des réservations
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Client</th>
                            <th>Date et heure</th>
                            <th>Table</th>
                            <th>Personnes</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservationsData as $reservation)
                            <tr>
                                <td>{{ $reservation->id }}</td>
                                <td>{{ $reservation->client_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($reservation->reservation_time)->format('d/m/Y H:i') }}</td>
                                <td>{{ $reservation->table ? 'Table ' . $reservation->table->number : 'N/A' }}</td>
                                <td>{{ $reservation->guests }}</td>
                                <td>
                                    <span class="badge bg-{{ 
                                        $reservation->status == 'confirmed' ? 'success' : 
                                        ($reservation->status == 'pending' ? 'warning' : 'danger') 
                                    }}">
                                        {{ $reservation->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('manager.reservations.show', $reservation->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                        @if ($reservationsData->isEmpty())
                            <tr>
                                <td colspan="7" class="text-center">Aucune réservation pour cette période</td>
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
        // Données pour les graphiques
        const reservationsData = @json($reservationsData);
        
        // Réservations par jour
        const reservationsByDay = {};
        const daysOfWeek = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        
        daysOfWeek.forEach(day => {
            reservationsByDay[day] = 0;
        });
        
        reservationsData.forEach(reservation => {
            const date = new Date(reservation.reservation_time);
            const dayName = daysOfWeek[date.getDay()];
            reservationsByDay[dayName]++;
        });
        
        const dayLabels = Object.keys(reservationsByDay);
        const dayValues = Object.values(reservationsByDay);
        
        const dayCtx = document.getElementById('reservationsByDayChart').getContext('2d');
        new Chart(dayCtx, {
            type: 'bar',
            data: {
                labels: dayLabels,
                datasets: [{
                    label: 'Nombre de réservations',
                    data: dayValues,
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    borderColor: 'rgba(75, 192, 192, 1)',
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
        
        // Réservations par statut
        const statusCounts = {
            'confirmed': 0,
            'pending': 0,
            'cancelled': 0
        };
        
        reservationsData.forEach(reservation => {
            if (statusCounts[reservation.status] !== undefined) {
                statusCounts[reservation.status]++;
            }
        });
        
        const statusLabels = ['Confirmées', 'En attente', 'Annulées'];
        const statusValues = [statusCounts.confirmed, statusCounts.pending, statusCounts.cancelled];
        const statusColors = [
            'rgba(40, 167, 69, 0.7)',
            'rgba(255, 193, 7, 0.7)',
            'rgba(220, 53, 69, 0.7)'
        ];
        
        const statusCtx = document.getElementById('reservationsByStatusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'pie',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusValues,
                    backgroundColor: statusColors,
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
        
        // Réservations par heure
        const hourCounts = {};
        for (let i = 11; i <= 22; i++) {
            hourCounts[i] = 0;
        }
        
        reservationsData.forEach(reservation => {
            const date = new Date(reservation.reservation_time);
            const hour = date.getHours();
            if (hourCounts[hour] !== undefined) {
                hourCounts[hour]++;
            }
        });
        
        const hourLabels = Object.keys(hourCounts).map(hour => `${hour}h`);
        const hourValues = Object.values(hourCounts);
        
        const hourCtx = document.getElementById('reservationsByHourChart').getContext('2d');
        new Chart(hourCtx, {
            type: 'line',
            data: {
                labels: hourLabels,
                datasets: [{
                    label: 'Nombre de réservations',
                    data: hourValues,
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
                            stepSize: 1
                        }
                    }
                }
            }
        });
        
        // Réservations par taille de groupe
        const groupSizes = {
            '1-2': 0,
            '3-4': 0,
            '5-6': 0,
            '7+': 0
        };
        
        reservationsData.forEach(reservation => {
            const guests = reservation.guests;
            if (guests <= 2) {
                groupSizes['1-2']++;
            } else if (guests <= 4) {
                groupSizes['3-4']++;
            } else if (guests <= 6) {
                groupSizes['5-6']++;
            } else {
                groupSizes['7+']++;
            }
        });
        
        const groupLabels = Object.keys(groupSizes);
        const groupValues = Object.values(groupSizes);
        const groupColors = [
            'rgba(255, 99, 132, 0.7)',
            'rgba(54, 162, 235, 0.7)',
            'rgba(255, 206, 86, 0.7)',
            'rgba(75, 192, 192, 0.7)'
        ];
        
        const groupCtx = document.getElementById('reservationsByGroupSizeChart').getContext('2d');
        new Chart(groupCtx, {
            type: 'bar',
            data: {
                labels: groupLabels,
                datasets: [{
                    label: 'Nombre de réservations',
                    data: groupValues,
                    backgroundColor: groupColors,
                    borderColor: groupColors.map(color => color.replace('0.7', '1')),
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
    });
</script>
@endsection

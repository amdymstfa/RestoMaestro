@extends('layouts.manager')

@section('title', 'Gestion des Commandes')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestion des Commandes</h1>
        <a href="{{ route('manager.orders.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nouvelle Commande
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filtres -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Statut</label>
                    <select name="status" class="form-select">
                        <option value="">Tous les statuts</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="preparing" {{ request('status') == 'preparing' ? 'selected' : '' }}>En préparation</option>
                        <option value="served" {{ request('status') == 'served' ? 'selected' : '' }}>Servi</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Terminé</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Table</label>
                    <select name="table_id" class="form-select">
                        <option value="">Toutes les tables</option>
                        @foreach(App\Models\Table::all() as $table)
                            <option value="{{ $table->id }}" {{ request('table_id') == $table->id ? 'selected' : '' }}>
                                Table {{ $table->number }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-outline-primary me-2">Filtrer</button>
                    <a href="{{ route('manager.orders.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des commandes -->
    <div class="card">
        <div class="card-body">
            @if($orders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Table</th>
                                <th>Serveur</th>
                                <th>Articles</th>
                                <th>Statut</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>
                                        @if($order->table)
                                            <span class="badge bg-info">Table {{ $order->table->number }}</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->user)
                                            {{ $order->user->name }}
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $order->orderItems->count() }} article(s)</small>
                                    </td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'pending' => 'warning',
                                                'preparing' => 'info',
                                                'served' => 'success',
                                                'completed' => 'secondary'
                                            ];
                                            $statusLabels = [
                                                'pending' => 'En attente',
                                                'preparing' => 'En préparation',
                                                'served' => 'Servi',
                                                'completed' => 'Terminé'
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                            {{ $statusLabels[$order->status] ?? $order->status }}
                                        </span>
                                    </td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('manager.orders.show', $order) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            @if($order->status !== 'completed')
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                            type="button" data-bs-toggle="dropdown">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        @if($order->status === 'pending')
                                                            <li>
                                                                <form method="POST" action="{{ route('manager.orders.update-status', $order) }}" class="d-inline">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="status" value="preparing">
                                                                    <button type="submit" class="dropdown-item">
                                                                        <i class="fas fa-play text-info"></i> Commencer préparation
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        @endif
                                                        @if($order->status === 'preparing')
                                                            <li>
                                                                <form method="POST" action="{{ route('manager.orders.update-status', $order) }}" class="d-inline">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="status" value="served">
                                                                    <button type="submit" class="dropdown-item">
                                                                        <i class="fas fa-check text-success"></i> Marquer comme servi
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        @endif
                                                        @if($order->status === 'served')
                                                            <li>
                                                                <form method="POST" action="{{ route('manager.orders.update-status', $order) }}" class="d-inline">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="status" value="completed">
                                                                    <button type="submit" class="dropdown-item">
                                                                        <i class="fas fa-flag text-secondary"></i> Terminer
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            @endif
                                            
                                            <form method="POST" action="{{ route('manager.orders.destroy', $order) }}" 
                                                  class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Aucune commande trouvée</h5>
                    <p class="text-muted">Commencez par créer une nouvelle commande.</p>
                    <a href="{{ route('manager.orders.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nouvelle Commande
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

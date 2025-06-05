@extends('layouts.manager')

@section('title', 'Commande #' . $order->id)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Commande #{{ $order->id }}</h1>
        <div>
            <a href="{{ route('manager.orders.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Informations de la commande -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informations</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Table:</strong>
                        @if($order->table)
                            <span class="badge bg-info ms-2">Table {{ $order->table->number }}</span>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </div>
                    
                    <div class="mb-3">
                        <strong>Serveur:</strong>
                        @if($order->user)
                            <span class="ms-2">{{ $order->user->name }}</span>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </div>
                    
                    <div class="mb-3">
                        <strong>Statut:</strong>
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
                        <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }} ms-2">
                            {{ $statusLabels[$order->status] ?? $order->status }}
                        </span>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Date de création:</strong>
                        <div class="text-muted">{{ $order->created_at->format('d/m/Y à H:i') }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Dernière mise à jour:</strong>
                        <div class="text-muted">{{ $order->updated_at->format('d/m/Y à H:i') }}</div>
                    </div>

                    <!-- Actions de changement de statut -->
                    @if($order->status !== 'completed')
                        <hr>
                        <h6>Changer le statut:</h6>
                        <div class="d-grid gap-2">
                            @if($order->status === 'pending')
                                <form method="POST" action="{{ route('manager.orders.update-status', $order) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="preparing">
                                    <button type="submit" class="btn btn-info btn-sm">
                                        <i class="fas fa-play"></i> Commencer préparation
                                    </button>
                                </form>
                            @endif
                            @if($order->status === 'preparing')
                                <form method="POST" action="{{ route('manager.orders.update-status', $order) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="served">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-check"></i> Marquer comme servi
                                    </button>
                                </form>
                            @endif
                            @if($order->status === 'served')
                                <form method="POST" action="{{ route('manager.orders.update-status', $order) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-flag"></i> Terminer
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Articles de la commande -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Articles commandés</h5>
                </div>
                <div class="card-body">
                    @if($order->orderItems->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Article</th>
                                        <th>Type</th>
                                        <th>Prix unitaire</th>
                                        <th>Quantité</th>
                                        <th>Sous-total</th>
                                        <th>Commentaire</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0; @endphp
                                    @foreach($order->orderItems as $item)
                                        @php 
                                            $subtotal = $item->menu ? $item->menu->price * $item->quantity : 0;
                                            $total += $subtotal;
                                        @endphp
                                        <tr>
                                            <td>
                                                @if($item->menu)
                                                    <strong>{{ $item->menu->name }}</strong>
                                                    @if($item->menu->description)
                                                        <br><small class="text-muted">{{ Str::limit($item->menu->description, 50) }}</small>
                                                    @endif
                                                @else
                                                    <span class="text-muted">Article supprimé</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->menu)
                                                    <span class="badge bg-light text-dark">{{ ucfirst($item->menu->type) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->menu)
                                                    {{ number_format($item->menu->price, 2) }} €
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{ $item->quantity }}</span>
                                            </td>
                                            <td>
                                                <strong>{{ number_format($subtotal, 2) }} €</strong>
                                            </td>
                                            <td>
                                                @if($item->comment)
                                                    <small class="text-muted">{{ $item->comment }}</small>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="table-active">
                                        <th colspan="4">Total</th>
                                        <th>{{ number_format($total, 2) }} €</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-utensils fa-2x text-muted mb-3"></i>
                            <h6 class="text-muted">Aucun article dans cette commande</h6>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

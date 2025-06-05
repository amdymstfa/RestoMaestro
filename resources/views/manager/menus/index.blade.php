@extends('layouts.manager')

@section('title', 'Gestion des Menus')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Gestion des Menus</h1>
            <p class="mb-0 text-muted">Gérez les plats et boissons de votre restaurant</p>
        </div>
        <a href="{{ route('manager.menus.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nouveau Plat
        </a>
    </div>

    <!-- Filtres -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('manager.menus.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Recherche</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="Nom ou description...">
                </div>
                <div class="col-md-3">
                    <label for="category" class="form-label">Catégorie</label>
                    <select class="form-select" id="category" name="category">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ ucfirst($category) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="is_available" class="form-label">Disponibilité</label>
                    <select class="form-select" id="is_available" name="is_available">
                        <option value="">Tous</option>
                        <option value="1" {{ request('is_available') == '1' ? 'selected' : '' }}>Disponible</option>
                        <option value="0" {{ request('is_available') == '0' ? 'selected' : '' }}>Indisponible</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-outline-primary me-2">
                        <i class="fas fa-search"></i> Filtrer
                    </button>
                    <a href="{{ route('manager.menus.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des plats -->
    <div class="card">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">
                Liste des Plats ({{ $menuItems->total() }} résultats)
            </h6>
        </div>
        <div class="card-body">
            @if($menuItems->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Nom</th>
                                <th>Catégorie</th>
                                <th>Prix</th>
                                <th>Disponibilité</th>
                                <th>Spécial</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($menuItems as $item)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $item->name }}</div>
                                        @if($item->description)
                                            <small class="text-muted">{{ Str::limit($item->description, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ ucfirst($item->category) }}</span>
                                    </td>
                                    <td class="fw-bold">{{ number_format($item->price, 2) }} €</td>
                                    <td>
                                        @if($item->is_available)
                                            <span class="badge bg-success">Disponible</span>
                                        @else
                                            <span class="badge bg-danger">Indisponible</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->is_special)
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-star"></i> Spécial
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('manager.menus.show', $item) }}" 
                                               class="btn btn-sm btn-outline-info" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('manager.menus.edit', $item) }}" 
                                               class="btn btn-sm btn-outline-primary" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('manager.menus.toggle-special', $item) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-warning" 
                                                        title="{{ $item->is_special ? 'Retirer du spécial' : 'Marquer comme spécial' }}">
                                                    <i class="fas fa-star"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('manager.menus.destroy', $item) }}" 
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce plat ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
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
                    {{ $menuItems->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-utensils fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Aucun plat trouvé</h5>
                    <p class="text-muted">Commencez par ajouter des plats à votre menu.</p>
                    <a href="{{ route('manager.menus.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Ajouter un plat
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

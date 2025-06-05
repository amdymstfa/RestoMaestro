@extends('layouts.manager')

@section('title', $menu->name)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">{{ $menu->name }}</h1>
            <p class="mb-0 text-muted">Détails du plat</p>
        </div>
        <div>
            <a href="{{ route('manager.menus.edit', $menu) }}" class="btn btn-primary me-2">
                <i class="fas fa-edit me-2"></i>Modifier
            </a>
            <a href="{{ route('manager.menus.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Retour à la liste
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Informations du plat</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>{{ $menu->name }}</h5>
                            @if($menu->description)
                                <p class="text-muted">{{ $menu->description }}</p>
                            @endif
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h3 class="text-primary">{{ number_format($menu->price, 2) }} €</h3>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h6>Catégorie</h6>
                            <span class="badge bg-secondary fs-6">{{ ucfirst($menu->category) }}</span>
                        </div>
                        <div class="col-md-6">
                            <h6>Statut</h6>
                            <div>
                                @if($menu->is_available)
                                    <span class="badge bg-success fs-6">Disponible</span>
                                @else
                                    <span class="badge bg-danger fs-6">Indisponible</span>
                                @endif
                                
                                @if($menu->is_special)
                                    <span class="badge bg-warning text-dark fs-6 ms-2">
                                        <i class="fas fa-star"></i> Spécial du jour
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($menu->allergens && count($menu->allergens) > 0)
                        <hr>
                        <h6>Allergènes</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($menu->allergens as $allergen)
                                <span class="badge bg-warning text-dark">{{ ucfirst($allergen) }}</span>
                            @endforeach
                        </div>
                    @endif

                    <hr>

                    <div class="row text-muted small">
                        <div class="col-md-6">
                            <strong>Créé le :</strong> {{ $menu->created_at->format('d/m/Y à H:i') }}
                        </div>
                        <div class="col-md-6">
                            <strong>Modifié le :</strong> {{ $menu->updated_at->format('d/m/Y à H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Actions rapides</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('manager.menus.edit', $menu) }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-2"></i>Modifier ce plat
                        </a>
                        
                        <form action="{{ route('manager.menus.toggle-special', $menu) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-warning w-100">
                                <i class="fas fa-star me-2"></i>
                                {{ $menu->is_special ? 'Retirer du spécial' : 'Marquer comme spécial' }}
                            </button>
                        </form>

                        <hr>

                        <form action="{{ route('manager.menus.destroy', $menu) }}" method="POST"
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce plat ? Cette action est irréversible.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="fas fa-trash me-2"></i>Supprimer ce plat
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            @if($menu->allergens && count($menu->allergens) > 0)
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-warning">
                            <i class="fas fa-exclamation-triangle"></i> Informations allergènes
                        </h6>
                    </div>
                    <div class="card-body">
                        <p class="small text-muted mb-2">Ce plat contient les allergènes suivants :</p>
                        <ul class="small mb-0">
                            @foreach($menu->allergens as $allergen)
                                <li>{{ ucfirst($allergen) }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

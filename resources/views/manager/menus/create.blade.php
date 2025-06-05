@extends('layouts.manager')

@section('title', 'Nouveau Plat')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Nouveau Plat</h1>
            <p class="mb-0 text-muted">Ajoutez un nouveau plat à votre menu</p>
        </div>
        <a href="{{ route('manager.menus.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour à la liste
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Informations du plat</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('manager.menus.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nom du plat <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Prix (€) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" min="0" 
                                           class="form-control @error('price') is-invalid @enderror" 
                                           id="price" name="price" value="{{ old('price') }}" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category" class="form-label">Catégorie <span class="text-danger">*</span></label>
                                    <select class="form-select @error('category') is-invalid @enderror" 
                                            id="category" name="category" required>
                                        <option value="">Sélectionnez une catégorie</option>
                                        <option value="entrée" {{ old('category') == 'entrée' ? 'selected' : '' }}>Entrée</option>
                                        <option value="plat" {{ old('category') == 'plat' ? 'selected' : '' }}>Plat principal</option>
                                        <option value="dessert" {{ old('category') == 'dessert' ? 'selected' : '' }}>Dessert</option>
                                        <option value="boisson" {{ old('category') == 'boisson' ? 'selected' : '' }}>Boisson</option>
                                        <option value="apéritif" {{ old('category') == 'apéritif' ? 'selected' : '' }}>Apéritif</option>
                                        @foreach($categories as $category)
                                            @if(!in_array($category, ['entrée', 'plat', 'dessert', 'boisson', 'apéritif']))
                                                <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>
                                                    {{ ucfirst($category) }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Allergènes</label>
                                    <div class="row">
                                        @php
                                            $allergens = ['gluten', 'lactose', 'œufs', 'poisson', 'crustacés', 'arachides', 'fruits à coque', 'soja'];
                                        @endphp
                                        @foreach($allergens as $allergen)
                                            <div class="col-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" 
                                                           name="allergens[]" value="{{ $allergen }}" 
                                                           id="allergen_{{ $loop->index }}"
                                                           {{ in_array($allergen, old('allergens', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="allergen_{{ $loop->index }}">
                                                        {{ ucfirst($allergen) }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" 
                                           name="is_available" value="1" id="is_available" 
                                           {{ old('is_available', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_available">
                                        Disponible à la vente
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" 
                                           name="is_special" value="1" id="is_special" 
                                           {{ old('is_special') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_special">
                                        <i class="fas fa-star text-warning"></i> Plat spécial du jour
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('manager.menus.index') }}" class="btn btn-secondary me-2">Annuler</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Créer le plat
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Conseils</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h6><i class="fas fa-lightbulb"></i> Conseils pour un bon plat</h6>
                        <ul class="mb-0 small">
                            <li>Utilisez un nom accrocheur et descriptif</li>
                            <li>Décrivez les ingrédients principaux</li>
                            <li>Mentionnez le mode de cuisson si pertinent</li>
                            <li>Indiquez tous les allergènes présents</li>
                            <li>Fixez un prix cohérent avec votre positionnement</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

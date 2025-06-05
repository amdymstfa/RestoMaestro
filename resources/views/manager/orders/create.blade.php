@extends('layouts.manager')

@section('title', 'Nouvelle Commande')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Nouvelle Commande</h1>
        <a href="{{ route('manager.orders.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    <form method="POST" action="{{ route('manager.orders.store') }}" id="orderForm">
        @csrf
        
        <div class="row">
            <!-- Sélection de la table -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Informations de base</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="table_id" class="form-label">Table *</label>
                            <select name="table_id" id="table_id" class="form-select @error('table_id') is-invalid @enderror" required>
                                <option value="">Sélectionner une table</option>
                                @foreach($tables as $table)
                                    <option value="{{ $table->id }}" {{ old('table_id') == $table->id ? 'selected' : '' }}>
                                        Table {{ $table->number }} ({{ $table->seats }} places)
                                    </option>
                                @endforeach
                            </select>
                            @error('table_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Résumé de la commande -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Résumé</h5>
                    </div>
                    <div class="card-body">
                        <div id="orderSummary">
                            <p class="text-muted">Aucun article sélectionné</p>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Total: </strong>
                            <strong id="totalPrice">0.00 €</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menu -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Menu</h5>
                    </div>
                    <div class="card-body">
                        @if($menus->count() > 0)
                            @foreach($menus as $type => $items)
                                <h6 class="text-primary mb-3">{{ ucfirst($type) }}</h6>
                                <div class="row mb-4">
                                    @foreach($items as $menu)
                                        <div class="col-md-6 mb-3">
                                            <div class="card menu-item" data-menu-id="{{ $menu->id }}" data-menu-name="{{ $menu->name }}" data-menu-price="{{ $menu->price }}">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <div class="flex-grow-1">
                                                            <h6 class="card-title mb-1">{{ $menu->name }}</h6>
                                                            @if($menu->description)
                                                                <p class="card-text text-muted small">{{ $menu->description }}</p>
                                                            @endif
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <span class="text-primary fw-bold">{{ number_format($menu->price, 2) }} €</span>
                                                                @if($menu->is_special)
                                                                    <span class="badge bg-warning">Spécial</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="ms-3">
                                                            <button type="button" class="btn btn-outline-primary btn-sm add-item">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-utensils fa-3x text-muted mb-3"></i>
                                <h6 class="text-muted">Aucun plat disponible</h6>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Articles sélectionnés (hidden inputs) -->
        <div id="selectedItems"></div>

        <!-- Boutons d'action -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('manager.orders.index') }}" class="btn btn-secondary me-2">Annuler</a>
                    <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                        <i class="fas fa-save"></i> Créer la commande
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Modal pour commentaire -->
<div class="modal fade" id="commentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un commentaire</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="itemComment" class="form-label">Commentaire pour <span id="itemName"></span></label>
                    <textarea class="form-control" id="itemComment" rows="3" placeholder="Instructions spéciales..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="saveComment">Ajouter</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let selectedItems = [];
    let currentMenuId = null;

    // Ajouter un article
    document.querySelectorAll('.add-item').forEach(button => {
        button.addEventListener('click', function() {
            const card = this.closest('.menu-item');
            const menuId = card.dataset.menuId;
            const menuName = card.dataset.menuName;
            const menuPrice = parseFloat(card.dataset.menuPrice);

            currentMenuId = menuId;
            document.getElementById('itemName').textContent = menuName;
            document.getElementById('itemComment').value = '';
            
            const modal = new bootstrap.Modal(document.getElementById('commentModal'));
            modal.show();
        });
    });

    // Sauvegarder le commentaire et ajouter l'article
    document.getElementById('saveComment').addEventListener('click', function() {
        const comment = document.getElementById('itemComment').value;
        const card = document.querySelector(`[data-menu-id="${currentMenuId}"]`);
        const menuName = card.dataset.menuName;
        const menuPrice = parseFloat(card.dataset.menuPrice);

        // Vérifier si l'article existe déjà
        const existingIndex = selectedItems.findIndex(item => item.menu_id == currentMenuId && item.comment == comment);
        
        if (existingIndex >= 0) {
            selectedItems[existingIndex].quantity++;
        } else {
            selectedItems.push({
                menu_id: currentMenuId,
                name: menuName,
                price: menuPrice,
                quantity: 1,
                comment: comment
            });
        }

        updateOrderSummary();
        updateHiddenInputs();
        
        const modal = bootstrap.Modal.getInstance(document.getElementById('commentModal'));
        modal.hide();
    });

    // Mettre à jour le résumé
    function updateOrderSummary() {
        const summaryDiv = document.getElementById('orderSummary');
        const totalDiv = document.getElementById('totalPrice');
        const submitBtn = document.getElementById('submitBtn');

        if (selectedItems.length === 0) {
            summaryDiv.innerHTML = '<p class="text-muted">Aucun article sélectionné</p>';
            totalDiv.textContent = '0.00 €';
            submitBtn.disabled = true;
            return;
        }

        let html = '';
        let total = 0;

        selectedItems.forEach((item, index) => {
            const subtotal = item.price * item.quantity;
            total += subtotal;

            html += `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="flex-grow-1">
                        <small><strong>${item.name}</strong></small>
                        ${item.comment ? `<br><small class="text-muted">${item.comment}</small>` : ''}
                    </div>
                    <div class="text-end">
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-outline-secondary" onclick="changeQuantity(${index}, -1)">-</button>
                            <span class="btn btn-outline-secondary">${item.quantity}</span>
                            <button type="button" class="btn btn-outline-secondary" onclick="changeQuantity(${index}, 1)">+</button>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger ms-1" onclick="removeItem(${index})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
        });

        summaryDiv.innerHTML = html;
        totalDiv.textContent = total.toFixed(2) + ' €';
        submitBtn.disabled = false;
    }

    // Changer la quantité
    window.changeQuantity = function(index, change) {
        selectedItems[index].quantity += change;
        if (selectedItems[index].quantity <= 0) {
            selectedItems.splice(index, 1);
        }
        updateOrderSummary();
        updateHiddenInputs();
    };

    // Supprimer un article
    window.removeItem = function(index) {
        selectedItems.splice(index, 1);
        updateOrderSummary();
        updateHiddenInputs();
    };

    // Mettre à jour les inputs cachés
    function updateHiddenInputs() {
        const container = document.getElementById('selectedItems');
        container.innerHTML = '';

        selectedItems.forEach((item, index) => {
            container.innerHTML += `
                <input type="hidden" name="items[${index}][menu_id]" value="${item.menu_id}">
                <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
                <input type="hidden" name="items[${index}][comment]" value="${item.comment}">
            `;
        });
    }
});
</script>
@endsection

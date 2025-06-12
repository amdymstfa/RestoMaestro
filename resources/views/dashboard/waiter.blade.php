<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Serveur - RestauManager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#f59e0b',
                        secondary: '#ef4444',
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="px-4 py-3 flex items-center justify-between">
            <h1 class="text-xl font-bold text-primary">🍽️ RestauManager</h1>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-600">Serveur: Marie Dubois</span>
                <button class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </div>
        </div>
    </header>

    <div class="max-w-6xl mx-auto p-4">
        <!-- Actions rapides -->
        <div class="mb-6">
            <button onclick="showOrderModal()" 
                    class="bg-primary hover:bg-amber-600 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Nouvelle Commande
            </button>
        </div>

        <!-- Tables -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Plan des tables -->
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-lg font-semibold mb-4">Tables</h2>
                <div class="grid grid-cols-3 gap-3">
                    <div class="table-card cursor-pointer hover:scale-105 transition-transform" 
                         onclick="selectTable(1, 'available')">
                        <div class="bg-green-100 border-2 border-green-500 rounded-lg p-3 text-center">
                            <div class="font-bold">Table 1</div>
                            <div class="text-sm text-green-700">Libre</div>
                            <div class="text-xs">4 places</div>
                        </div>
                    </div>
                    
                    <div class="table-card cursor-pointer hover:scale-105 transition-transform" 
                         onclick="selectTable(2, 'occupied')">
                        <div class="bg-red-100 border-2 border-red-500 rounded-lg p-3 text-center">
                            <div class="font-bold">Table 2</div>
                            <div class="text-sm text-red-700">Occupée</div>
                            <div class="text-xs">2 places</div>
                        </div>
                    </div>
                    
                    <div class="table-card cursor-pointer hover:scale-105 transition-transform" 
                         onclick="selectTable(3, 'available')">
                        <div class="bg-green-100 border-2 border-green-500 rounded-lg p-3 text-center">
                            <div class="font-bold">Table 3</div>
                            <div class="text-sm text-green-700">Libre</div>
                            <div class="text-xs">6 places</div>
                        </div>
                    </div>
                    
                    <div class="table-card cursor-pointer hover:scale-105 transition-transform" 
                         onclick="selectTable(4, 'occupied')">
                        <div class="bg-red-100 border-2 border-red-500 rounded-lg p-3 text-center">
                            <div class="font-bold">Table 4</div>
                            <div class="text-sm text-red-700">Occupée</div>
                            <div class="text-xs">4 places</div>
                        </div>
                    </div>
                    
                    <div class="table-card cursor-pointer hover:scale-105 transition-transform" 
                         onclick="selectTable(5, 'available')">
                        <div class="bg-green-100 border-2 border-green-500 rounded-lg p-3 text-center">
                            <div class="font-bold">Table 5</div>
                            <div class="text-sm text-green-700">Libre</div>
                            <div class="text-xs">2 places</div>
                        </div>
                    </div>
                    
                    <div class="table-card cursor-pointer hover:scale-105 transition-transform" 
                         onclick="selectTable(6, 'available')">
                        <div class="bg-green-100 border-2 border-green-500 rounded-lg p-3 text-center">
                            <div class="font-bold">Table 6</div>
                            <div class="text-sm text-green-700">Libre</div>
                            <div class="text-xs">8 places</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Commandes actives -->
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-lg font-semibold mb-4">Commandes en cours</h2>
                <div class="space-y-3">
                    <div class="border rounded-lg p-3">
                        <div class="flex justify-between items-start mb-2">
                            <span class="font-medium">Table 2</span>
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">
                                En préparation
                            </span>
                        </div>
                        <div class="text-sm text-gray-600 mb-2">
                            • Steak frites (bien cuit)<br>
                            • Salade César
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-500">14:30</span>
                            <button onclick="markAsReady(1)" 
                                    class="text-green-600 hover:text-green-800 text-sm">
                                <i class="fas fa-check mr-1"></i>Prêt
                            </button>
                        </div>
                    </div>

                    <div class="border rounded-lg p-3">
                        <div class="flex justify-between items-start mb-2">
                            <span class="font-medium">Table 4</span>
                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                Prêt à servir
                            </span>
                        </div>
                        <div class="text-sm text-gray-600 mb-2">
                            • Burger maison<br>
                            • Lasagnes
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-500">14:15</span>
                            <button onclick="markAsServed(2)" 
                                    class="text-blue-600 hover:text-blue-800 text-sm">
                                <i class="fas fa-utensils mr-1"></i>Servi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de commande simplifié -->
    <div id="orderModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
                <div class="p-4 border-b">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold">Nouvelle Commande</h3>
                        <button onclick="closeOrderModal()" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="p-4">
                    <form id="orderForm">
                        <!-- Sélection table -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Table</label>
                            <select id="tableSelect" class="w-full border rounded-md px-3 py-2">
                                <option value="">Choisir une table</option>
                                <option value="1">Table 1 (4 places)</option>
                                <option value="2">Table 2 (2 places)</option>
                                <option value="3">Table 3 (6 places)</option>
                                <option value="4">Table 4 (4 places)</option>
                                <option value="5">Table 5 (2 places)</option>
                                <option value="6">Table 6 (8 places)</option>
                            </select>
                        </div>

                        <!-- Menu rapide -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Plats</label>
                            <div class="space-y-2 max-h-48 overflow-y-auto">
                                <label class="flex items-center p-2 hover:bg-gray-50 rounded">
                                    <input type="checkbox" name="items[]" value="steak_frites" class="mr-3">
                                    <span class="flex-1">Steak frites</span>
                                    <span class="text-gray-600">22€</span>
                                </label>
                                <label class="flex items-center p-2 hover:bg-gray-50 rounded">
                                    <input type="checkbox" name="items[]" value="burger_maison" class="mr-3">
                                    <span class="flex-1">Burger maison</span>
                                    <span class="text-gray-600">16€</span>
                                </label>
                                <label class="flex items-center p-2 hover:bg-gray-50 rounded">
                                    <input type="checkbox" name="items[]" value="lasagnes" class="mr-3">
                                    <span class="flex-1">Lasagnes</span>
                                    <span class="text-gray-600">18€</span>
                                </label>
                                <label class="flex items-center p-2 hover:bg-gray-50 rounded">
                                    <input type="checkbox" name="items[]" value="salade_cesar" class="mr-3">
                                    <span class="flex-1">Salade César</span>
                                    <span class="text-gray-600">12€</span>
                                </label>
                                <label class="flex items-center p-2 hover:bg-gray-50 rounded">
                                    <input type="checkbox" name="items[]" value="soupe_oignon" class="mr-3">
                                    <span class="flex-1">Soupe à l'oignon</span>
                                    <span class="text-gray-600">8€</span>
                                </label>
                                <label class="flex items-center p-2 hover:bg-gray-50 rounded">
                                    <input type="checkbox" name="items[]" value="tiramisu" class="mr-3">
                                    <span class="flex-1">Tiramisu</span>
                                    <span class="text-gray-600">7€</span>
                                </label>
                                <label class="flex items-center p-2 hover:bg-gray-50 rounded">
                                    <input type="checkbox" name="items[]" value="coca_cola" class="mr-3">
                                    <span class="flex-1">Coca-Cola</span>
                                    <span class="text-gray-600">3€</span>
                                </label>
                                <label class="flex items-center p-2 hover:bg-gray-50 rounded">
                                    <input type="checkbox" name="items[]" value="vin_rouge" class="mr-3">
                                    <span class="flex-1">Vin rouge</span>
                                    <span class="text-gray-600">25€</span>
                                </label>
                            </div>
                        </div>

                        <!-- Commentaires -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Commentaires</label>
                            <textarea name="notes" rows="2" 
                                      placeholder="Cuisson, allergies, préférences..."
                                      class="w-full border rounded-md px-3 py-2 text-sm"></textarea>
                        </div>

                        <!-- Total -->
                        <div class="mb-4 p-3 bg-gray-50 rounded-md">
                            <div class="flex justify-between items-center">
                                <span class="font-medium">Total:</span>
                                <span id="totalPrice" class="text-lg font-bold text-primary">0€</span>
                            </div>
                        </div>

                        <div class="flex space-x-3">
                            <button type="button" onclick="closeOrderModal()" 
                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                                Annuler
                            </button>
                            <button type="submit" 
                                    class="flex-1 px-4 py-2 bg-primary text-white rounded-md hover:bg-amber-600">
                                <i class="fas fa-paper-plane mr-2"></i>Envoyer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Prix des plats
        const itemPrices = {
            'steak_frites': 22,
            'burger_maison': 16,
            'lasagnes': 18,
            'salade_cesar': 12,
            'soupe_oignon': 8,
            'tiramisu': 7,
            'coca_cola': 3,
            'vin_rouge': 25
        };

        // Gestion du modal
        function showOrderModal() {
            document.getElementById('orderModal').classList.remove('hidden');
            setupOrderForm();
        }

        function closeOrderModal() {
            document.getElementById('orderModal').classList.add('hidden');
            document.getElementById('orderForm').reset();
            updateTotal();
        }

        // Sélection de table depuis le plan
        function selectTable(tableId, status) {
            showOrderModal();
            document.getElementById('tableSelect').value = tableId;
        }

        // Configuration du formulaire
        function setupOrderForm() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"][name="items[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateTotal);
            });
            updateTotal();
        }

        // Calcul du total
        function updateTotal() {
            let total = 0;
            const checkboxes = document.querySelectorAll('input[type="checkbox"][name="items[]"]:checked');
            
            checkboxes.forEach(checkbox => {
                const price = itemPrices[checkbox.value] || 0;
                total += price;
            });

            document.getElementById('totalPrice').textContent = total + '€';
        }

        // Actions sur les commandes
        function markAsReady(orderId) {
            updateOrderStatus(orderId, 'ready');
        }

        function markAsServed(orderId) {
            updateOrderStatus(orderId, 'served');
        }

        function updateOrderStatus(orderId, status) {
            // Simulation de l'appel API
            console.log(`Commande ${orderId} marquée comme ${status}`);
            
            // En réalité, faire un appel fetch vers l'API
            // fetch(`/orders/${orderId}/status`, {
            //     method: 'PATCH',
            //     headers: { 'Content-Type': 'application/json' },
            //     body: JSON.stringify({ status: status })
            // })
            // .then(response => response.json())
            // .then(data => {
            //     if (data.success) {
            //         location.reload();
            //     }
            // });
            
            // Pour la démo, on simule un rechargement
            setTimeout(() => {
                alert(`Commande #${orderId} mise à jour !`);
                // location.reload();
            }, 500);
        }

        // Soumission du formulaire
        document.getElementById('orderForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const tableId = formData.get('table_id') || document.getElementById('tableSelect').value;
            
            if (!tableId) {
                alert('Veuillez sélectionner une table');
                return;
            }
            
            const selectedItems = [];
            const checkboxes = document.querySelectorAll('input[type="checkbox"][name="items[]"]:checked');
            
            if (checkboxes.length === 0) {
                alert('Veuillez sélectionner au moins un plat');
                return;
            }
            
            checkboxes.forEach(checkbox => {
                selectedItems.push(checkbox.value);
            });

            const notes = formData.get('notes') || '';
            
            // Simulation de l'envoi
            console.log('Nouvelle commande:', {
                table: tableId,
                items: selectedItems,
                notes: notes
            });
            
            // En réalité, envoyer à l'API
            // fetch('/orders', {
            //     method: 'POST',
            //     headers: { 'Content-Type': 'application/json' },
            //     body: JSON.stringify({
            //         table_id: tableId,
            //         items: selectedItems,
            //         notes: notes
            //     })
            // })
            // .then(response => response.json())
            // .then(data => {
            //     if (data.success) {
            //         closeOrderModal();
            //         location.reload();
            //     }
            // });
            
            // Pour la démo
            closeOrderModal();
            alert('Commande envoyée en cuisine !');
        });
    </script>
</body>
</html>
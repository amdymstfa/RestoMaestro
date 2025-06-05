<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table {{ $table->number }} - RestauManager</title>
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
    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Sidebar -->
        @include('manager.partials.sidebar')

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Top Navigation -->
            @include('manager.partials.header', ['title' => 'Détails de la Table'])

            <!-- Content -->
            <main class="max-w-6xl mx-auto py-6 sm:px-6 lg:px-8">
                <div class="mb-6 flex justify-between items-center">
                    <a href="{{ route('manager.tables.index') }}" class="text-primary hover:text-amber-600">
                        <i class="fas fa-arrow-left mr-2"></i>Retour aux tables
                    </a>
                    <div class="flex space-x-3">
                        <a href="{{ route('manager.tables.edit', $table) }}" 
                           class="bg-primary hover:bg-amber-600 text-white px-4 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-edit mr-2"></i>Modifier
                        </a>
                        <form method="POST" action="{{ route('manager.tables.destroy', $table) }}" 
                              class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette table ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                <i class="fas fa-trash mr-2"></i>Supprimer
                            </button>
                        </form>
                    </div>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Informations de la table -->
                <div class="bg-white shadow rounded-lg mb-6">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">
                            Table {{ $table->number }}
                        </h3>

                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Numéro</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $table->number }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Nombre de places</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $table->seats }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Statut actuel</dt>
                                <dd class="mt-1">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $table->status == 'free' ? 'bg-green-100 text-green-800' : 
                                           ($table->status == 'occupied' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ $table->status == 'free' ? 'Libre' : 
                                           ($table->status == 'occupied' ? 'Occupée' : 'Réservée') }}
                                    </span>
                                </dd>
                            </div>
                        </dl>

                        <!-- Actions rapides pour changer le statut -->
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Changer le statut :</label>
                            <div class="flex space-x-2">
                                <button onclick="updateTableStatus({{ $table->id }}, 'free')" 
                                        class="px-4 py-2 text-sm bg-green-100 text-green-800 rounded hover:bg-green-200 
                                        {{ $table->status == 'free' ? 'ring-2 ring-green-500' : '' }}">
                                    <i class="fas fa-check mr-1"></i>Libre
                                </button>
                                <button onclick="updateTableStatus({{ $table->id }}, 'occupied')" 
                                        class="px-4 py-2 text-sm bg-red-100 text-red-800 rounded hover:bg-red-200
                                        {{ $table->status == 'occupied' ? 'ring-2 ring-red-500' : '' }}">
                                    <i class="fas fa-user mr-1"></i>Occupée
                                </button>
                                <button onclick="updateTableStatus({{ $table->id }}, 'reserved')" 
                                        class="px-4 py-2 text-sm bg-yellow-100 text-yellow-800 rounded hover:bg-yellow-200
                                        {{ $table->status == 'reserved' ? 'ring-2 ring-yellow-500' : '' }}">
                                    <i class="fas fa-calendar mr-1"></i>Réservée
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Commande actuelle -->
                @if($currentOrder)
                    <div class="bg-white shadow rounded-lg mb-6">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                Commande actuelle
                            </h3>
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-sm font-medium text-blue-900">Commande #{{ $currentOrder->id }}</p>
                                        <p class="text-sm text-blue-700">Statut: {{ $currentOrder->status }}</p>
                                        <p class="text-sm text-blue-700">Créée le: {{ $currentOrder->created_at->format('d/m/Y à H:i') }}</p>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $currentOrder->status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Historique des commandes -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                            Historique des commandes récentes
                        </h3>
                        @if($recentOrders->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Commande
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Date
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Statut
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Total
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($recentOrders as $order)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    #{{ $order->id }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        {{ $order->status }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ number_format($order->total_amount ?? 0, 2, ',', ' ') }} €
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">Aucune commande récente pour cette table.</p>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        function updateTableStatus(tableId, status) {
            fetch(`/manager/tables/${tableId}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ status: status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Erreur lors de la mise à jour du statut');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erreur lors de la mise à jour du statut');
            });
        }
    </script>
</body>
</html>

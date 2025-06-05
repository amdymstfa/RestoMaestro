<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tables - RestauManager</title>
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
            @include('manager.partials.header', ['title' => 'Gestion des Tables'])

            <!-- Content -->
            <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <!-- Header avec boutons d'action -->
                <div class="mb-6 flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Tables</h1>
                        <p class="mt-1 text-sm text-gray-600">Gérez les tables du restaurant</p>
                    </div>
                    <a href="{{ route('manager.tables.create') }}" class="bg-primary hover:bg-amber-600 text-white px-4 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-plus mr-2"></i>Nouvelle table
                    </a>
                </div>

                <!-- Filtres -->
                <div class="bg-white shadow rounded-lg mb-6">
                    <div class="p-6">
                        <form method="GET" action="{{ route('manager.tables.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
                                <select name="status" id="status" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                                    <option value="">Tous les statuts</option>
                                    <option value="free" {{ request('status') == 'free' ? 'selected' : '' }}>Libre</option>
                                    <option value="occupied" {{ request('status') == 'occupied' ? 'selected' : '' }}>Occupée</option>
                                    <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>Réservée</option>
                                </select>
                            </div>
                            <div>
                                <label for="seats" class="block text-sm font-medium text-gray-700">Nombre de places minimum</label>
                                <input type="number" name="seats" id="seats" value="{{ request('seats') }}" min="1" max="20"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium mr-2">
                                    <i class="fas fa-search mr-2"></i>Filtrer
                                </button>
                                <a href="{{ route('manager.tables.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md text-sm font-medium">
                                    Réinitialiser
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Messages de succès/erreur -->
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Grille des tables -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @forelse($tables as $table)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900">Table {{ $table->number }}</h3>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $table->status == 'free' ? 'bg-green-100 text-green-800' : 
                                           ($table->status == 'occupied' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ $table->status == 'free' ? 'Libre' : 
                                           ($table->status == 'occupied' ? 'Occupée' : 'Réservée') }}
                                    </span>
                                </div>
                                
                                <div class="space-y-2 mb-4">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-users mr-2"></i>
                                        {{ $table->seats }} places
                                    </div>
                                </div>

                                <!-- Actions rapides pour changer le statut -->
                                <div class="mb-4">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Changer le statut :</label>
                                    <div class="flex space-x-1">
                                        <button onclick="updateTableStatus({{ $table->id }}, 'free')" 
                                                class="flex-1 px-2 py-1 text-xs bg-green-100 text-green-800 rounded hover:bg-green-200 
                                                {{ $table->status == 'free' ? 'ring-2 ring-green-500' : '' }}">
                                            Libre
                                        </button>
                                        <button onclick="updateTableStatus({{ $table->id }}, 'occupied')" 
                                                class="flex-1 px-2 py-1 text-xs bg-red-100 text-red-800 rounded hover:bg-red-200
                                                {{ $table->status == 'occupied' ? 'ring-2 ring-red-500' : '' }}">
                                            Occupée
                                        </button>
                                        <button onclick="updateTableStatus({{ $table->id }}, 'reserved')" 
                                                class="flex-1 px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded hover:bg-yellow-200
                                                {{ $table->status == 'reserved' ? 'ring-2 ring-yellow-500' : '' }}">
                                            Réservée
                                        </button>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex space-x-2">
                                    <a href="{{ route('manager.tables.show', $table) }}" 
                                       class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-3 rounded text-sm">
                                        <i class="fas fa-eye mr-1"></i>Voir
                                    </a>
                                    <a href="{{ route('manager.tables.edit', $table) }}" 
                                       class="flex-1 bg-primary hover:bg-amber-600 text-white text-center py-2 px-3 rounded text-sm">
                                        <i class="fas fa-edit mr-1"></i>Modifier
                                    </a>
                                    <form method="POST" action="{{ route('manager.tables.destroy', $table) }}" 
                                          class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette table ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white py-2 px-3 rounded text-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <i class="fas fa-utensils text-gray-400 text-4xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune table trouvée</h3>
                            <p class="text-gray-600 mb-4">Commencez par créer votre première table.</p>
                            <a href="{{ route('manager.tables.create') }}" class="bg-primary hover:bg-amber-600 text-white px-4 py-2 rounded-md text-sm font-medium">
                                <i class="fas fa-plus mr-2"></i>Créer une table
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($tables->hasPages())
                    <div class="mt-6">
                        {{ $tables->links() }}
                    </div>
                @endif
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

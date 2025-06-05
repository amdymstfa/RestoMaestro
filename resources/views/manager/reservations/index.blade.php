<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservations - RestauManager</title>
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
            @include('manager.partials.header', ['title' => 'Gestion des Réservations'])

            <!-- Content -->
            <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <!-- Header avec boutons d'action -->
                <div class="mb-6 flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Réservations</h1>
                        <p class="mt-1 text-sm text-gray-600">Gérez toutes les réservations du restaurant</p>
                    </div>
                    <a href="{{ route('manager.reservations.create') }}" class="bg-primary hover:bg-amber-600 text-white px-4 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-plus mr-2"></i>Nouvelle réservation
                    </a>
                </div>

                <!-- Filtres -->
                <div class="bg-white shadow rounded-lg mb-6">
                    <div class="p-6">
                        <form method="GET" action="{{ route('manager.reservations.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                                <input type="date" name="date" id="date" value="{{ request('date') }}" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                            </div>
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
                                <select name="status" id="status" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                                    <option value="">Tous les statuts</option>
                                    <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>À venir</option>
                                    <option value="today" {{ request('status') == 'today' ? 'selected' : '' }}>Aujourd'hui</option>
                                    <option value="past" {{ request('status') == 'past' ? 'selected' : '' }}>Passées</option>
                                </select>
                            </div>
                            <div>
                                <label for="table_id" class="block text-sm font-medium text-gray-700">Table</label>
                                <select name="table_id" id="table_id" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                                    <option value="">Toutes les tables</option>
                                    @foreach($tables as $table)
                                        <option value="{{ $table->id }}" {{ request('table_id') == $table->id ? 'selected' : '' }}>
                                            Table {{ $table->number }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium mr-2">
                                    <i class="fas fa-search mr-2"></i>Filtrer
                                </button>
                                <a href="{{ route('manager.reservations.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md text-sm font-medium">
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

                <!-- Liste des réservations -->
                <div class="bg-white shadow rounded-lg">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Client
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date & Heure
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Table
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Téléphone
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Statut
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($reservations as $reservation)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $reservation->client_name }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $reservation->reservation_time->format('d/m/Y H:i') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                Table {{ $reservation->table ? $reservation->table->number : 'Non assignée' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $reservation->phone ?: '-' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $now = \Carbon\Carbon::now();
                                                $reservationTime = $reservation->reservation_time;
                                                $status = $reservationTime->isPast() ? 'past' : ($reservationTime->isToday() ? 'today' : 'upcoming');
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $status == 'past' ? 'bg-gray-100 text-gray-800' : 
                                                   ($status == 'today' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                                {{ $status == 'past' ? 'Passée' : ($status == 'today' ? 'Aujourd\'hui' : 'À venir') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('manager.reservations.show', $reservation) }}" 
                                                   class="text-blue-600 hover:text-blue-900">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('manager.reservations.edit', $reservation) }}" 
                                                   class="text-primary hover:text-amber-600">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('manager.reservations.destroy', $reservation) }}" 
                                                      class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                            Aucune réservation trouvée
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($reservations->hasPages())
                        <div class="px-6 py-3 border-t border-gray-200">
                            {{ $reservations->links() }}
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>
</body>
</html>

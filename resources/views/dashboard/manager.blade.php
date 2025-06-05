<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Manager - RestauManager</title>
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
        <aside class="bg-gray-800 text-white w-full md:w-64 md:min-h-screen">
            <div class="p-4 flex items-center justify-between md:justify-center">
                <h1 class="text-2xl font-bold text-primary">🍽️ RestauManager</h1>
                <button class="md:hidden text-white" id="mobile-menu-button">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <div class="hidden md:block" id="sidebar-menu">
                <nav class="mt-8">
                    <div class="px-4 py-2 text-xs text-gray-400 uppercase tracking-wider">
                        Général
                    </div>
                    <a href="{{ route('manager.dashboard') }}" class="block px-4 py-2 {{ request()->routeIs('manager.dashboard') ? 'text-white bg-gray-900' : 'text-gray-300' }} hover:bg-gray-700">
                        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                    </a>
                    <a href="{{ route('manager.reservations.index') }}" class="block px-4 py-2 {{ request()->routeIs('manager.reservations.*') ? 'text-white bg-gray-900' : 'text-gray-300' }} hover:bg-gray-700">
                        <i class="fas fa-calendar-alt mr-2"></i> Réservations
                    </a>
                    <a href="{{ route('manager.tables.index') }}" class="block px-4 py-2 {{ request()->routeIs('manager.tables.*') ? 'text-white bg-gray-900' : 'text-gray-300' }} hover:bg-gray-700">
                        <i class="fas fa-utensils mr-2"></i> Tables
                    </a>
                    <a href="{{ route('manager.orders.index') }}" class="block px-4 py-2 {{ request()->routeIs('manager.orders.*') ? 'text-white bg-gray-900' : 'text-gray-300' }} hover:bg-gray-700">
                        <i class="fas fa-clipboard-list mr-2"></i> Commandes
                    </a>
                    
                    <div class="px-4 py-2 mt-6 text-xs text-gray-400 uppercase tracking-wider">
                        Administration
                    </div>
                    <a href="{{ route('manager.staff.index') }}" class="block px-4 py-2 {{ request()->routeIs('manager.staff.*') ? 'text-white bg-gray-900' : 'text-gray-300' }} hover:bg-gray-700">
                        <i class="fas fa-users mr-2"></i> Personnel
                    </a>
                    <a href="{{ route('manager.menus.index') }}" class="block px-4 py-2 {{ request()->routeIs('manager.menus.*') ? 'text-white bg-gray-900' : 'text-gray-300' }} hover:bg-gray-700">
                        <i class="fas fa-book-open mr-2"></i> Menus
                    </a>
                    <a href="{{ route('manager.reports.index') }}" class="block px-4 py-2 {{ request()->routeIs('manager.reports.*') ? 'text-white bg-gray-900' : 'text-gray-300' }} hover:bg-gray-700">
                        <i class="fas fa-chart-bar mr-2"></i> Rapports
                    </a>
                    <a href="{{ route('manager.settings') }}" class="block px-4 py-2 {{ request()->routeIs('manager.settings') ? 'text-white bg-gray-900' : 'text-gray-300' }} hover:bg-gray-700">
                        <i class="fas fa-cog mr-2"></i> Paramètres
                    </a>
                    
                    <div class="px-4 py-2 mt-6 text-xs text-gray-400 uppercase tracking-wider">
                        Compte
                    </div>
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-300 hover:bg-gray-700">
                        <i class="fas fa-user mr-2"></i> Profil
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="w-full text-left block px-4 py-2 text-gray-300 hover:bg-gray-700">
                            <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                        </button>
                    </form>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Top Navigation -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-800">Dashboard Manager</h2>
                    <div class="flex items-center">
                        <span class="mr-4 text-gray-600">{{ Auth::user()->name }}</span>
                        <div class="relative">
                            <button class="flex items-center focus:outline-none">
                                <div class="h-8 w-8 rounded-full bg-primary flex items-center justify-center text-white">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-primary rounded-md p-3">
                                    <i class="fas fa-users text-white"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Clients aujourd'hui
                                        </dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-2xl font-semibold text-gray-900">
                                                {{ $stats['clients_today'] }}
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                    <i class="fas fa-euro-sign text-white"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Chiffre d'affaires
                                        </dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-2xl font-semibold text-gray-900">
                                                {{ number_format($stats['revenue_today'], 2, ',', ' ') }} €
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                    <i class="fas fa-calendar-check text-white"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Réservations
                                        </dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-2xl font-semibold text-gray-900">
                                                {{ $stats['reservations_count'] }}
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                    <i class="fas fa-utensils text-white"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Tables occupées
                                        </dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-2xl font-semibold text-gray-900">
                                                {{ $stats['occupied_tables'] }}/{{ $stats['total_tables'] }}
                                            </div>
                                            <div class="ml-2 flex items-baseline text-sm font-semibold text-gray-600">
                                                {{ $stats['tables_occupancy_rate'] }}%
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Actions rapides</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="{{ route('manager.reservations.create') }}" class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-blue-500 rounded-md p-2">
                                    <i class="fas fa-plus text-white"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Nouvelle réservation</p>
                                </div>
                            </div>
                        </a>
                        
                        <a href="{{ route('manager.tables.create') }}" class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-green-500 rounded-md p-2">
                                    <i class="fas fa-plus text-white"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Nouvelle table</p>
                                </div>
                            </div>
                        </a>
                        
                        <a href="{{ route('manager.menus.create') }}" class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-yellow-500 rounded-md p-2">
                                    <i class="fas fa-plus text-white"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Nouveau plat</p>
                                </div>
                            </div>
                        </a>
                        
                        <a href="{{ route('manager.staff.create') }}" class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-purple-500 rounded-md p-2">
                                    <i class="fas fa-plus text-white"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Nouveau membre</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Main Content Sections -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Réservations du jour -->
                    <div class="lg:col-span-2 bg-white shadow rounded-lg">
                        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Réservations du jour
                            </h3>
                            <a href="{{ route('manager.reservations.index') }}" class="text-sm text-primary hover:text-amber-600">
                                Voir tout
                            </a>
                        </div>
                        <div class="border-t border-gray-200">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Client
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Heure
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Table
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Statut
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($todayReservations as $reservation)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $reservation['client'] }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ $reservation['time'] }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ $reservation['table'] }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        {{ $reservation['status'] == 'confirmed' ? 'bg-green-100 text-green-800' : 
                                                           ($reservation['status'] == 'upcoming' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                                        {{ $reservation['status'] == 'confirmed' ? 'Confirmé' : 
                                                           ($reservation['status'] == 'upcoming' ? 'Bientôt' : 'Passé') }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                                    Aucune réservation pour aujourd'hui
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Activité récente -->
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-4 py-5 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Activité récente
                            </h3>
                        </div>
                        <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                            <dl class="sm:divide-y sm:divide-gray-200">
                                @forelse($recentActivity as $activity)
                                    <div class="py-3 sm:py-4 sm:px-6">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <div class="h-8 w-8 rounded-full {{ $activity['icon_bg'] }} flex items-center justify-center">
                                                    <i class="{{ $activity['icon'] }} {{ $activity['icon_color'] }}"></i>
                                                </div>
                                            </div>
                                            <div class="ml-3 flex-1">
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ $activity['message'] }}
                                                </p>
                                                <p class="mt-1 text-sm text-gray-500">
                                                    {{ $activity['time'] }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="py-3 sm:py-4 sm:px-6">
                                        <p class="text-sm text-gray-500">Aucune activité récente</p>
                                    </div>
                                @endforelse
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Plan de salle -->
                <div class="mt-8 bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Plan de salle
                        </h3>
                        <a href="{{ route('manager.tables.index') }}" class="text-sm text-primary hover:text-amber-600">
                            Gérer les tables
                        </a>
                    </div>
                    <div class="border-t border-gray-200 p-4">
                        <div class="bg-gray-100 p-4 rounded-lg h-64 relative">
                            <!-- Tables -->
                            @foreach($tables as $table)
                                <div class="absolute {{ $table['position'] }} h-16 w-16 
                                    {{ $table['status'] == 'free' ? 'bg-green-200 border-green-500' : 
                                       ($table['status'] == 'reserved' ? 'bg-yellow-200 border-yellow-500' : 'bg-red-200 border-red-500') }} 
                                    {{ $table['shape'] == 'round' ? 'rounded-full' : 'rounded-lg' }} 
                                    border-2 flex items-center justify-center cursor-pointer hover:opacity-80"
                                    onclick="showTableDetails({{ $table['id'] }})">
                                    <span class="font-bold">{{ $table['number'] }}</span>
                                </div>
                            @endforeach
                            
                            <!-- Légende -->
                            <div class="absolute bottom-2 left-2 flex space-x-4 text-xs">
                                <div class="flex items-center">
                                    <div class="h-3 w-3 bg-green-200 border border-green-500 rounded-full mr-1"></div>
                                    <span>Libre</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="h-3 w-3 bg-red-200 border border-red-500 rounded-full mr-1"></div>
                                    <span>Occupée</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="h-3 w-3 bg-yellow-200 border border-yellow-500 rounded-full mr-1"></div>
                                    <span>Réservée</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('sidebar-menu');
            menu.classList.toggle('hidden');
        });

        // Table details
        function showTableDetails(tableId) {
            window.location.href = `/manager/tables/${tableId}`;
        }
    </script>
</body>
</html>

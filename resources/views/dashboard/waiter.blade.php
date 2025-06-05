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
                        Service
                    </div>
                    <a href="#" class="block px-4 py-2 text-white bg-gray-900 hover:bg-gray-700">
                        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                    </a>
                    <a href="#" class="block px-4 py-2 text-gray-300 hover:bg-gray-700">
                        <i class="fas fa-utensils mr-2"></i> Tables
                    </a>
                    <a href="#" class="block px-4 py-2 text-gray-300 hover:bg-gray-700">
                        <i class="fas fa-clipboard-list mr-2"></i> Commandes
                    </a>
                    <a href="#" class="block px-4 py-2 text-gray-300 hover:bg-gray-700">
                        <i class="fas fa-calendar-alt mr-2"></i> Réservations
                    </a>
                    <a href="#" class="block px-4 py-2 text-gray-300 hover:bg-gray-700">
                        <i class="fas fa-book-open mr-2"></i> Menu
                    </a>
                    
                    <div class="px-4 py-2 mt-6 text-xs text-gray-400 uppercase tracking-wider">
                        Compte
                    </div>
                    <a href="#" class="block px-4 py-2 text-gray-300 hover:bg-gray-700">
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
                    <h2 class="text-xl font-semibold text-gray-800">Dashboard Serveur</h2>
                    <div class="flex items-center">
                        <span class="mr-4 text-gray-600">Marie Durand</span>
                        <div class="relative">
                            <button class="flex items-center focus:outline-none">
                                <div class="h-8 w-8 rounded-full bg-primary flex items-center justify-center text-white">
                                    MD
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <!-- Quick Actions -->
                <div class="mb-8">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                        Actions rapides
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <button class="bg-primary hover:bg-amber-600 text-white p-4 rounded-lg flex flex-col items-center justify-center">
                            <i class="fas fa-plus-circle text-2xl mb-2"></i>
                            <span>Nouvelle commande</span>
                        </button>
                        <button class="bg-green-500 hover:bg-green-600 text-white p-4 rounded-lg flex flex-col items-center justify-center">
                            <i class="fas fa-calendar-plus text-2xl mb-2"></i>
                            <span>Ajouter réservation</span>
                        </button>
                        <button class="bg-blue-500 hover:bg-blue-600 text-white p-4 rounded-lg flex flex-col items-center justify-center">
                            <i class="fas fa-chair text-2xl mb-2"></i>
                            <span>Attribuer table</span>
                        </button>
                        <button class="bg-purple-500 hover:bg-purple-600 text-white p-4 rounded-lg flex flex-col items-center justify-center">
                            <i class="fas fa-receipt text-2xl mb-2"></i>
                            <span>Encaisser</span>
                        </button>
                    </div>
                </div>

                <!-- Tables Status -->
                <div class="bg-white shadow rounded-lg mb-8">
                    <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Statut des tables
                        </h3>
                        <button class="bg-primary hover:bg-amber-600 text-white px-4 py-2 rounded-md text-sm">
                            Rafraîchir
                        </button>
                    </div>
                    <div class="border-t border-gray-200 p-4">
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                            <!-- Table 1 -->
                            <div class="bg-green-100 border-2 border-green-500 rounded-lg p-4 flex flex-col items-center">
                                <div class="text-xl font-bold">Table 1</div>
                                <div class="text-sm text-green-700 mt-1">Libre</div>
                                <div class="text-xs mt-2">4 personnes</div>
                            </div>
                            
                            <!-- Table 2 -->
                            <div class="bg-red-100 border-2 border-red-500 rounded-lg p-4 flex flex-col items-center">
                                <div class="text-xl font-bold">Table 2</div>
                                <div class="text-sm text-red-700 mt-1">Occupée</div>
                                <div class="text-xs mt-2">2 personnes</div>
                                <div class="text-xs mt-1">Depuis 45 min</div>
                            </div>
                            
                            <!-- Table 3 -->
                            <div class="bg-red-100 border-2 border-red-500 rounded-lg p-4 flex flex-col items-center">
                                <div class="text-xl font-bold">Table 3</div>
                                <div class="text-sm text-red-700 mt-1">Occupée</div>
                                <div class="text-xs mt-2">6 personnes</div>
                                <div class="text-xs mt-1">Depuis 15 min</div>
                            </div>
                            
                            <!-- Table 4 -->
                            <div class="bg-yellow-100 border-2 border-yellow-500 rounded-lg p-4 flex flex-col items-center">
                                <div class="text-xl font-bold">Table 4</div>
                                <div class="text-sm text-yellow-700 mt-1">Réservée</div>
                                <div class="text-xs mt-2">4 personnes</div>
                                <div class="text-xs mt-1">13:30</div>
                            </div>
                            
                            <!-- Table 5 -->
                            <div class="bg-green-100 border-2 border-green-500 rounded-lg p-4 flex flex-col items-center">
                                <div class="text-xl font-bold">Table 5</div>
                                <div class="text-sm text-green-700 mt-1">Libre</div>
                                <div class="text-xs mt-2">2 personnes</div>
                            </div>
                            
                            <!-- Table 6 -->
                            <div class="bg-red-100 border-2 border-red-500 rounded-lg p-4 flex flex-col items-center">
                                <div class="text-xl font-bold">Table 6</div>
                                <div class="text-sm text-red-700 mt-1">Occupée</div>
                                <div class="text-xs mt-2">4 personnes</div>
                                <div class="text-xs mt-1">Depuis 30 min</div>
                            </div>
                            
                            <!-- Table 7 -->
                            <div class="bg-green-100 border-2 border-green-500 rounded-lg p-4 flex flex-col items-center">
                                <div class="text-xl font-bold">Table 7</div>
                                <div class="text-sm text-green-700 mt-1">Libre</div>
                                <div class="text-xs mt-2">2 personnes</div>
                            </div>
                            
                            <!-- Table 8 -->
                            <div class="bg-yellow-100 border-2 border-yellow-500 rounded-lg p-4 flex flex-col items-center">
                                <div class="text-xl font-bold">Table 8</div>
                                <div class="text-sm text-yellow-700 mt-1">Réservée</div>
                                <div class="text-xs mt-2">8 personnes</div>
                                <div class="text-xs mt-1">20:00</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Orders -->
                <div class="bg-white shadow rounded-lg mb-8">
                    <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Commandes actives
                        </h3>
                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-primary text-white">
                            3 commandes
                        </span>
                    </div>
                    <div class="border-t border-gray-200">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Table
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Commande
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Heure
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
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">Table 2</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">2x Salade César</div>
                                            <div class="text-sm text-gray-900">1x Lasagnes</div>
                                            <div class="text-sm text-gray-900">1x Tiramisu</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">12:15</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                En préparation
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button class="text-primary hover:text-amber-600 mr-3">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="text-green-600 hover:text-green-900">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">Table 3</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">4x Steak frites</div>
                                            <div class="text-sm text-gray-900">2x Soupe à l'oignon</div>
                                            <div class="text-sm text-gray-900">1x Bouteille vin rouge</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">12:30</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Prêt à servir
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button class="text-primary hover:text-amber-600 mr-3">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="text-green-600 hover:text-green-900">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">Table 6</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">2x Burger maison</div>
                                            <div class="text-sm text-gray-900">2x Frites</div>
                                            <div class="text-sm text-gray-900">2x Coca-Cola</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">12:45</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Servi
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button class="text-primary hover:text-amber-600 mr-3">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="text-green-600 hover:text-green-900">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Reservations -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Réservations à venir
                        </h3>
                    </div>
                    <div class="border-t border-gray-200">
                        <ul class="divide-y divide-gray-200">
                            <li class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-primary flex items-center justify-center text-white">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                Martin Dubois
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                4 personnes
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="text-sm text-gray-900 mr-4">
                                            13:30
                                        </div>
                                        <div>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Table 4
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-primary flex items-center justify-center text-white">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                Famille Petit
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                8 personnes
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="text-sm text-gray-900 mr-4">
                                            20:00
                                        </div>
                                        <div>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Table 8
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-primary flex items-center justify-center text-white">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                Julie Blanc
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                2 personnes
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="text-sm text-gray-900 mr-4">
                                            20:30
                                        </div>
                                        <div>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                À attribuer
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
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
    </script>
</body>
</html>

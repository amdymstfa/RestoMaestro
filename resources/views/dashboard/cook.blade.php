<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Cuisinier - RestauManager</title>
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
                        Cuisine
                    </div>
                    <a href="#" class="block px-4 py-2 text-white bg-gray-900 hover:bg-gray-700">
                        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                    </a>
                    <a href="#" class="block px-4 py-2 text-gray-300 hover:bg-gray-700">
                        <i class="fas fa-clipboard-list mr-2"></i> Commandes
                    </a>
                    <a href="#" class="block px-4 py-2 text-gray-300 hover:bg-gray-700">
                        <i class="fas fa-book-open mr-2"></i> Menu
                    </a>
                    <a href="#" class="block px-4 py-2 text-gray-300 hover:bg-gray-700">
                        <i class="fas fa-warehouse mr-2"></i> Stocks
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
                    <h2 class="text-xl font-semibold text-gray-800">Dashboard Cuisinier</h2>
                    <div class="flex items-center">
                        <span class="mr-4 text-gray-600">Pierre Martin</span>
                        <div class="relative">
                            <button class="flex items-center focus:outline-none">
                                <div class="h-8 w-8 rounded-full bg-primary flex items-center justify-center text-white">
                                    PM
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <!-- Kitchen Status -->
                <div class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                    <i class="fas fa-clock text-white"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            En attente
                                        </dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-2xl font-semibold text-gray-900">
                                                4
                                            </div>
                                            <div class="ml-2 flex items-baseline text-sm font-semibold text-yellow-600">
                                                commandes
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
                                    <i class="fas fa-fire text-white"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            En préparation
                                        </dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-2xl font-semibold text-gray-900">
                                                2
                                            </div>
                                            <div class="ml-2 flex items-baseline text-sm font-semibold text-blue-600">
                                                commandes
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
                                    <i class="fas fa-check text-white"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Prêt à servir
                                        </dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-2xl font-semibold text-gray-900">
                                                3
                                            </div>
                                            <div class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                                                commandes
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Orders Queue -->
                <div class="bg-white shadow rounded-lg mb-8">
                    <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            File d'attente des commandes
                        </h3>
                        <button class="bg-primary hover:bg-amber-600 text-white px-4 py-2 rounded-md text-sm">
                            Rafraîchir
                        </button>
                    </div>
                    <div class="border-t border-gray-200">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            #
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Table
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Plats
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
                                            <div class="text-sm font-medium text-gray-900">#1245</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">Table 2</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">2x Salade César</div>
                                            <div class="text-sm text-gray-900">1x Lasagnes</div>
                                            <div class="text-sm text-gray-900">1x Tiramisu</div>
                                            <div class="text-xs text-gray-500 mt-1">Note: Sans oignons pour les salades</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">12:15</div>
                                            <div class="text-xs text-red-500">Il y a 20 min</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                En préparation
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm">
                                                Prêt
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">#1246</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">Table 3</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">4x Steak frites</div>
                                            <div class="text-sm text-gray-900">2x Soupe à l'oignon</div>
                                            <div class="text-xs text-gray-500 mt-1">Note: 2 steaks bien cuits, 2 à point</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">12:30</div>
                                            <div class="text-xs text-red-500">Il y a 5 min</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                En préparation
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm">
                                                Prêt
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">#1247</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">Table 5</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">1x Risotto aux champignons</div>
                                            <div class="text-sm text-gray-900">1x Poulet rôti</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">12:40</div>
                                            <div class="text-xs text-gray-500">Nouveau</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                En attente
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button class="bg-primary hover:bg-amber-600 text-white px-3 py-1 rounded-md text-sm">
                                                Commencer
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">#1248</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">Table 7</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">2x Salade niçoise</div>
                                            <div class="text-sm text-gray-900">2x Crème brûlée</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">12:42</div>
                                            <div class="text-xs text-gray-500">Nouveau</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                En attente
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button class="bg-primary hover:bg-amber-600 text-white px-3 py-1 rounded-md text-sm">
                                                Commencer
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Ready Orders -->
                <div class="bg-white shadow rounded-lg mb-8">
                    <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Commandes prêtes à servir
                        </h3>
                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            3 commandes
                        </span>
                    </div>
                    <div class="border-t border-gray-200">
                        <ul class="divide-y divide-gray-200">
                            <li class="px-4 py-4 sm:px-6 flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-500">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            Commande #1242 - Table 1
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            2x Quiche Lorraine, 2x Salade verte
                                        </div>
                                    </div>
                                </div>
                                <div class="text-sm text-gray-500">
                                    Prêt depuis 5 min
                                </div>
                            </li>
                            <li class="px-4 py-4 sm:px-6 flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-500">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            Commande #1243 - Table 4
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            1x Bœuf bourguignon, 1x Tarte aux pommes
                                        </div>
                                    </div>
                                </div>
                                <div class="text-sm text-gray-500">
                                    Prêt depuis 3 min
                                </div>
                            </li>
                            <li class="px-4 py-4 sm:px-6 flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-500">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            Commande #1244 - Table 8
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            3x Magret de canard, 3x Mousse au chocolat
                                        </div>
                                    </div>
                                </div>
                                <div class="text-sm text-gray-500">
                                    Prêt depuis 1 min
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Low Stock Alert -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Alertes de stock
                        </h3>
                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            3 alertes
                        </span>
                    </div>
                    <div class="border-t border-gray-200">
                        <ul class="divide-y divide-gray-200">
                            <li class="px-4 py-4 sm:px-6 flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-red-100 flex items-center justify-center text-red-500">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            Vin rouge - Bordeaux
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            Reste 2 bouteilles
                                        </div>
                                    </div>
                                </div>
                                <button class="bg-primary hover:bg-amber-600 text-white px-3 py-1 rounded-md text-sm">
                                    Commander
                                </button>
                            </li>
                            <li class="px-4 py-4 sm:px-6 flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-red-100 flex items-center justify-center text-red-500">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            Champignons frais
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            Reste 300g
                                        </div>
                                    </div>
                                </div>
                                <button class="bg-primary hover:bg-amber-600 text-white px-3 py-1 rounded-md text-sm">
                                    Commander
                                </button>
                            </li>
                            <li class="px-4 py-4 sm:px-6 flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-500">
                                        <i class="fas fa-exclamation"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            Crème fraîche
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            Reste 500ml
                                        </div>
                                    </div>
                                </div>
                                <button class="bg-primary hover:bg-amber-600 text-white px-3 py-1 rounded-md text-sm">
                                    Commander
                                </button>
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

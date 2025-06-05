<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Client - RestauManager</title>
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
                        Mon compte
                    </div>
                    <a href="#" class="block px-4 py-2 text-white bg-gray-900 hover:bg-gray-700">
                        <i class="fas fa-tachometer-alt mr-2"></i> Tableau de bord
                    </a>
                    <a href="#" class="block px-4 py-2 text-gray-300 hover:bg-gray-700">
                        <i class="fas fa-calendar-alt mr-2"></i> Mes réservations
                    </a>
                    <a href="#" class="block px-4 py-2 text-gray-300 hover:bg-gray-700">
                        <i class="fas fa-utensils mr-2"></i> Menu du restaurant
                    </a>
                    <a href="#" class="block px-4 py-2 text-gray-300 hover:bg-gray-700">
                        <i class="fas fa-star mr-2"></i> Avis et commentaires
                    </a>
                    
                    <div class="px-4 py-2 mt-6 text-xs text-gray-400 uppercase tracking-wider">
                        Paramètres
                    </div>
                    <a href="#" class="block px-4 py-2 text-gray-300 hover:bg-gray-700">
                        <i class="fas fa-user mr-2"></i> Profil
                    </a>
                    <a href="#" class="block px-4 py-2 text-gray-300 hover:bg-gray-700">
                        <i class="fas fa-bell mr-2"></i> Notifications
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
                    <h2 class="text-xl font-semibold text-gray-800">Espace Client</h2>
                    <div class="flex items-center">
                        <span class="mr-4 text-gray-600">Sophie Bernard</span>
                        <div class="relative">
                            <button class="flex items-center focus:outline-none">
                                <div class="h-8 w-8 rounded-full bg-primary flex items-center justify-center text-white">
                                    SB
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <!-- Welcome Banner -->
                <div class="bg-white shadow rounded-lg mb-8">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Bienvenue, Sophie !
                        </h3>
                        <div class="mt-2 max-w-xl text-sm text-gray-500">
                            <p>
                                Réservez votre table, consultez le menu et gérez vos préférences depuis votre espace personnel.
                            </p>
                        </div>
                        <div class="mt-5">
                            <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-amber-600 focus:outline-none">
                                Réserver une table
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-primary rounded-md p-3">
                                    <i class="fas fa-calendar-check text-white"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Réservations à venir
                                        </dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-2xl font-semibold text-gray-900">
                                                1
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
                                    <i class="fas fa-history text-white"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Visites passées
                                        </dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-2xl font-semibold text-gray-900">
                                                8
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
                                    <i class="fas fa-star text-white"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Points fidélité
                                        </dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-2xl font-semibold text-gray-900">
                                                250
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Reservation -->
                <div class="bg-white shadow rounded-lg mb-8">
                    <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Votre prochaine réservation
                        </h3>
                        <a href="#" class="text-sm text-primary hover:text-amber-600">
                            Voir toutes mes réservations
                        </a>
                    </div>
                    <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-calendar-alt text-yellow-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        Votre réservation est confirmée pour le 15 juin à 20h00.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="sm:flex sm:items-center sm:justify-between">
                            <div>
                                <h4 class="text-lg font-medium text-gray-900">Dîner pour 2 personnes</h4>
                                <div class="mt-1 flex items-center">
                                    <i class="fas fa-calendar text-gray-400 mr-1"></i>
                                    <span class="text-sm text-gray-500">15 juin 2024</span>
                                    <i class="fas fa-clock text-gray-400 ml-3 mr-1"></i>
                                    <span class="text-sm text-gray-500">20:00</span>
                                    <i class="fas fa-user text-gray-400 ml-3 mr-1"></i>
                                    <span class="text-sm text-gray-500">2 personnes</span>
                                </div>
                                <div class="mt-2 text-sm text-gray-500">
                                    <p>Note: Table près de la fenêtre demandée</p>
                                </div>
                            </div>
                            <div class="mt-5 sm:mt-0 sm:flex sm:space-x-3">
                                <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                                    Modifier
                                </button>
                                <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none">
                                    Annuler
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Menu Preview -->
                <div class="bg-white shadow rounded-lg mb-8">
                    <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Menu du jour
                        </h3>
                        <a href="#" class="text-sm text-primary hover:text-amber-600">
                            Voir le menu complet
                        </a>
                    </div>
                    <div class="border-t border-gray-200">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Entrées -->
                                <div>
                                    <h4 class="text-md font-medium text-gray-900 mb-4">Entrées</h4>
                                    <ul class="space-y-3">
                                        <li class="border-b border-gray-100 pb-2">
                                            <div class="flex justify-between">
                                                <span class="font-medium">Salade César</span>
                                                <span class="text-gray-600">9€</span>
                                            </div>
                                            <p class="text-sm text-gray-500">Laitue romaine, parmesan, croûtons, sauce César</p>
                                        </li>
                                        <li class="border-b border-gray-100 pb-2">
                                            <div class="flex justify-between">
                                                <span class="font-medium">Soupe à l'oignon</span>
                                                <span class="text-gray-600">8€</span>
                                            </div>
                                            <p class="text-sm text-gray-500">Oignons caramélisés, bouillon, croûtons, gruyère</p>
                                        </li>
                                        <li>
                                            <div class="flex justify-between">
                                                <span class="font-medium">Foie gras maison</span>
                                                <span class="text-gray-600">15€</span>
                                            </div>
                                            <p class="text-sm text-gray-500">Foie gras de canard, chutney de figues, pain toasté</p>
                                        </li>
                                    </ul>
                                </div>
                                
                                <!-- Plats -->
                                <div>
                                    <h4 class="text-md font-medium text-gray-900 mb-4">Plats</h4>
                                    <ul class="space-y-3">
                                        <li class="border-b border-gray-100 pb-2">
                                            <div class="flex justify-between">
                                                <span class="font-medium">Steak frites</span>
                                                <span class="text-gray-600">22€</span>
                                            </div>
                                            <p class="text-sm text-gray-500">Entrecôte grillée, frites maison, sauce béarnaise</p>
                                        </li>
                                        <li class="border-b border-gray-100 pb-2">
                                            <div class="flex justify-between">
                                                <span class="font-medium">Risotto aux champignons</span>
                                                <span class="text-gray-600">18€</span>
                                            </div>
                                            <p class="text-sm text-gray-500">Riz arborio, champignons, parmesan, truffe</p>
                                        </li>
                                        <li>
                                            <div class="flex justify-between">
                                                <span class="font-medium">Filet de bar</span>
                                                <span class="text-gray-600">24€</span>
                                            </div>
                                            <p class="text-sm text-gray-500">Filet de bar grillé, légumes de saison, sauce vierge</p>
                                        </li>
                                    </ul>
                                </div>
                                
                                <!-- Desserts -->
                                <div>
                                    <h4 class="text-md font-medium text-gray-900 mb-4">Desserts</h4>
                                    <ul class="space-y-3">
                                        <li class="border-b border-gray-100 pb-2">
                                            <div class="flex justify-between">
                                                <span class="font-medium">Tiramisu</span>
                                                <span class="text-gray-600">8€</span>
                                            </div>
                                            <p class="text-sm text-gray-500">Mascarpone, café, biscuits, cacao</p>
                                        </li>
                                        <li class="border-b border-gray-100 pb-2">
                                            <div class="flex justify-between">
                                                <span class="font-medium">Crème brûlée</span>
                                                <span class="text-gray-600">7€</span>
                                            </div>
                                            <p class="text-sm text-gray-500">Crème vanillée, caramel</p>
                                        </li>
                                        <li>
                                            <div class="flex justify-between">
                                                <span class="font-medium">Tarte aux fruits</span>
                                                <span class="text-gray-600">9€</span>
                                            </div>
                                            <p class="text-sm text-gray-500">Pâte sablée, crème pâtissière, fruits de saison</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reservation Form -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Réserver une table
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Choisissez la date, l'heure et le nombre de personnes pour votre prochaine visite.
                        </p>
                    </div>
                    <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                        <form class="space-y-6">
                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <div class="sm:col-span-3">
                                    <label for="date" class="block text-sm font-medium text-gray-700">
                                        Date
                                    </label>
                                    <div class="mt-1">
                                        <input type="date" name="date" id="date" class="shadow-sm focus:ring-primary focus:border-primary block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="time" class="block text-sm font-medium text-gray-700">
                                        Heure
                                    </label>
                                    <div class="mt-1">
                                        <select id="time" name="time" class="shadow-sm focus:ring-primary focus:border-primary block w-full sm:text-sm border-gray-300 rounded-md">
                                            <option>12:00</option>
                                            <option>12:30</option>
                                            <option>13:00</option>
                                            <option>13:30</option>
                                            <option>19:00</option>
                                            <option>19:30</option>
                                            <option>20:00</option>
                                            <option>20:30</option>
                                            <option>21:00</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="guests" class="block text-sm font-medium text-gray-700">
                                        Nombre de personnes
                                    </label>
                                    <div class="mt-1">
                                        <select id="guests" name="guests" class="shadow-sm focus:ring-primary focus:border-primary block w-full sm:text-sm border-gray-300 rounded-md">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                            <option>6</option>
                                            <option>7</option>
                                            <option>8</option>
                                            <option>Plus de 8</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="sm:col-span-4">
                                    <label for="special-requests" class="block text-sm font-medium text-gray-700">
                                        Demandes spéciales
                                    </label>
                                    <div class="mt-1">
                                        <input type="text" name="special-requests" id="special-requests" class="shadow-sm focus:ring-primary focus:border-primary block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Table près de la fenêtre, allergies...">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    Réserver maintenant
                                </button>
                            </div>
                        </form>
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

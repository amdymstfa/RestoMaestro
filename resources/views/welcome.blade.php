<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RestauManager - Système de Gestion Restaurant</title>
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
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-2xl font-bold text-primary">🍽️ RestauManager</h1>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary px-3 py-2 rounded-md text-sm font-medium">
                        Connexion
                    </a>
                    <a href="{{ route('register') }}" class="bg-primary hover:bg-amber-600 text-white px-4 py-2 rounded-md text-sm font-medium">
                        S'inscrire
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-primary to-amber-600">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-extrabold text-white sm:text-5xl md:text-6xl">
                    Gérez votre restaurant
                    <span class="block text-amber-200">en toute simplicité</span>
                </h1>
                <p class="mt-3 max-w-md mx-auto text-base text-amber-100 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                    Solution complète pour la gestion des réservations, commandes, menus et performances de votre restaurant.
                </p>
                <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                    <div class="rounded-md shadow">
                        <a href="{{ route('register') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-primary bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10">
                            Commencer gratuitement
                        </a>
                    </div>
                    <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3">
                        <a href="{{ route('login') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary bg-opacity-60 hover:bg-opacity-70 md:py-4 md:text-lg md:px-10">
                            Se connecter
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-primary font-semibold tracking-wide uppercase">Fonctionnalités</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Tout ce dont vous avez besoin
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Une solution complète pour optimiser la gestion de votre restaurant
                </p>
            </div>

            <div class="mt-10">
                <div class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                    <!-- Feature 1 -->
                    <div class="relative">
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-primary text-white">
                            📅
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Gestion des Réservations</p>
                        <p class="mt-2 ml-16 text-base text-gray-500">
                            Système de réservation en ligne avec visualisation du plan de salle en temps réel.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="relative">
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-primary text-white">
                            🍽️
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Gestion du Menu</p>
                        <p class="mt-2 ml-16 text-base text-gray-500">
                            Création et modification facile des menus avec gestion des stocks et allergies.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="relative">
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-primary text-white">
                            📱
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Prise de Commande</p>
                        <p class="mt-2 ml-16 text-base text-gray-500">
                            Interface tactile optimisée pour les serveurs avec transmission directe en cuisine.
                        </p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="relative">
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-primary text-white">
                            📊
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Analytics & Reporting</p>
                        <p class="mt-2 ml-16 text-base text-gray-500">
                            Suivi des performances avec rapports détaillés et export PDF/Excel.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Roles Section -->
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-primary font-semibold tracking-wide uppercase">Accès Multi-Rôles</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Interface adaptée à chaque utilisateur
                </p>
            </div>

            <div class="mt-10 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Gérant -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="text-3xl">👨‍💼</div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Gérant</dt>
                                    <dd class="text-lg font-medium text-gray-900">Dashboard complet</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3">
                        <div class="text-sm text-gray-500">
                            Accès à tous les modules et rapports
                        </div>
                    </div>
                </div>

                <!-- Serveur -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="text-3xl">👨‍🍳</div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Serveur</dt>
                                    <dd class="text-lg font-medium text-gray-900">Prise de commande</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3">
                        <div class="text-sm text-gray-500">
                            Réservations et gestion des tables
                        </div>
                    </div>
                </div>

                <!-- Cuisinier -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="text-3xl">👩‍🍳</div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Cuisinier</dt>
                                    <dd class="text-lg font-medium text-gray-900">Suivi commandes</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3">
                        <div class="text-sm text-gray-500">
                            Gestion des préparations
                        </div>
                    </div>
                </div>

                <!-- Client -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="text-3xl">👤</div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Client</dt>
                                    <dd class="text-lg font-medium text-gray-900">Réservation</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3">
                        <div class="text-sm text-gray-500">
                            Consultation des menus
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 md:flex md:items-center md:justify-between lg:px-8">
            <div class="flex justify-center space-x-6 md:order-2">
                <p class="text-gray-400 text-sm">
                    © 2024 RestauManager. Tous droits réservés.
                </p>
            </div>
            <div class="mt-8 md:mt-0 md:order-1">
                <p class="text-center text-base text-gray-400">
                    Solution de gestion pour restaurants modernes
                </p>
            </div>
        </div>
    </footer>
</body>
</html>

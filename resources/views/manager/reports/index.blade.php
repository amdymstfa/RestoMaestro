<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapports - RestauManager</title>
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
            @include('manager.partials.header', ['title' => 'Rapports et Analyses'])

            <!-- Content -->
            <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Rapports et Analyses</h1>
                    <p class="mt-1 text-sm text-gray-600">Suivez les performances de votre restaurant</p>
                </div>

                <!-- Statistiques rapides -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-primary rounded-md p-3">
                                    <i class="fas fa-shopping-cart text-white"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Commandes aujourd'hui
                                        </dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-2xl font-semibold text-gray-900">
                                                {{ $stats['total_orders_today'] }}
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
                                            CA aujourd'hui
                                        </dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-2xl font-semibold text-gray-900">
                                                {{ number_format($stats['total_revenue_today'], 2, ',', ' ') }} €
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
                                            Réservations aujourd'hui
                                        </dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-2xl font-semibold text-gray-900">
                                                {{ $stats['total_reservations_today'] }}
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
                                    <i class="fas fa-chart-line text-white"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            CA ce mois
                                        </dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-2xl font-semibold text-gray-900">
                                                {{ number_format($stats['total_revenue_month'], 2, ',', ' ') }} €
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Types de rapports -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Rapport des ventes -->
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="h-12 w-12 rounded-md bg-green-500 flex items-center justify-center">
                                        <i class="fas fa-chart-bar text-white text-xl"></i>
                                    </div>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <h3 class="text-lg font-medium text-gray-900">Rapport des Ventes</h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Analysez vos revenus et performances commerciales
                                    </p>
                                </div>
                            </div>
                            <div class="mt-6">
                                <a href="{{ route('manager.reports.sales') }}" 
                                   class="w-full bg-green-600 hover:bg-green-700 text-white text-center py-2 px-4 rounded-md text-sm font-medium">
                                    Voir le rapport
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Rapport des réservations -->
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="h-12 w-12 rounded-md bg-blue-500 flex items-center justify-center">
                                        <i class="fas fa-calendar-alt text-white text-xl"></i>
                                    </div>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <h3 class="text-lg font-medium text-gray-900">Rapport des Réservations</h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Suivez l'évolution de vos réservations
                                    </p>
                                </div>
                            </div>
                            <div class="mt-6">
                                <a href="{{ route('manager.reports.reservations') }}" 
                                   class="w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-md text-sm font-medium">
                                    Voir le rapport
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Performance du personnel -->
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="h-12 w-12 rounded-md bg-purple-500 flex items-center justify-center">
                                        <i class="fas fa-users text-white text-xl"></i>
                                    </div>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <h3 class="text-lg font-medium text-gray-900">Performance du Personnel</h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Évaluez les performances de votre équipe
                                    </p>
                                </div>
                            </div>
                            <div class="mt-6">
                                <a href="{{ route('manager.reports.staff-performance') }}" 
                                   class="w-full bg-purple-600 hover:bg-purple-700 text-white text-center py-2 px-4 rounded-md text-sm font-medium">
                                    Voir le rapport
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation #{{ $reservation->id }} - RestauManager</title>
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
            @include('manager.partials.header', ['title' => 'Détails de la Réservation'])

            <!-- Content -->
            <main class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
                <div class="mb-6 flex justify-between items-center">
                    <a href="{{ route('manager.reservations.index') }}" class="text-primary hover:text-amber-600">
                        <i class="fas fa-arrow-left mr-2"></i>Retour aux réservations
                    </a>
                    <div class="flex space-x-3">
                        <a href="{{ route('manager.reservations.edit', $reservation) }}" 
                           class="bg-primary hover:bg-amber-600 text-white px-4 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-edit mr-2"></i>Modifier
                        </a>
                        <form method="POST" action="{{ route('manager.reservations.destroy', $reservation) }}" 
                              class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?')">
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

                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">
                            Réservation #{{ $reservation->id }}
                        </h3>

                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Nom du client</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $reservation->client_name }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Téléphone</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $reservation->phone ?: 'Non renseigné' }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Date et heure</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $reservation->reservation_time->format('d/m/Y à H:i') }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Table</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if($reservation->table)
                                        Table {{ $reservation->table->number }} ({{ $reservation->table->seats }} places)
                                    @else
                                        Non assignée
                                    @endif
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Créée par</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $reservation->creator ? $reservation->creator->name : 'Système' }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Date de création</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $reservation->created_at->format('d/m/Y à H:i') }}</dd>
                            </div>

                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Statut</dt>
                                <dd class="mt-1">
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
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>

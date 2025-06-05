<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Réservation - RestauManager</title>
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
            @include('manager.partials.header', ['title' => 'Nouvelle Réservation'])

            <!-- Content -->
            <main class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
                <div class="mb-6">
                    <a href="{{ route('manager.reservations.index') }}" class="text-primary hover:text-amber-600">
                        <i class="fas fa-arrow-left mr-2"></i>Retour aux réservations
                    </a>
                </div>

                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">
                            Créer une nouvelle réservation
                        </h3>

                        <form method="POST" action="{{ route('manager.reservations.store') }}">
                            @csrf
                            
                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <!-- Nom du client -->
                                <div class="sm:col-span-3">
                                    <label for="client_name" class="block text-sm font-medium text-gray-700">
                                        Nom du client *
                                    </label>
                                    <div class="mt-1">
                                        <input type="text" name="client_name" id="client_name" required
                                            value="{{ old('client_name') }}"
                                            class="shadow-sm focus:ring-primary focus:border-primary block w-full sm:text-sm border-gray-300 rounded-md @error('client_name') border-red-500 @enderror">
                                    </div>
                                    @error('client_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Téléphone -->
                                <div class="sm:col-span-3">
                                    <label for="phone" class="block text-sm font-medium text-gray-700">
                                        Téléphone
                                    </label>
                                    <div class="mt-1">
                                        <input type="tel" name="phone" id="phone"
                                            value="{{ old('phone') }}"
                                            class="shadow-sm focus:ring-primary focus:border-primary block w-full sm:text-sm border-gray-300 rounded-md @error('phone') border-red-500 @enderror">
                                    </div>
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Date et heure -->
                                <div class="sm:col-span-3">
                                    <label for="reservation_time" class="block text-sm font-medium text-gray-700">
                                        Date et heure *
                                    </label>
                                    <div class="mt-1">
                                        <input type="datetime-local" name="reservation_time" id="reservation_time" required
                                            value="{{ old('reservation_time') }}"
                                            min="{{ now()->format('Y-m-d\TH:i') }}"
                                            class="shadow-sm focus:ring-primary focus:border-primary block w-full sm:text-sm border-gray-300 rounded-md @error('reservation_time') border-red-500 @enderror">
                                    </div>
                                    @error('reservation_time')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Table -->
                                <div class="sm:col-span-3">
                                    <label for="table_id" class="block text-sm font-medium text-gray-700">
                                        Table *
                                    </label>
                                    <div class="mt-1">
                                        <select name="table_id" id="table_id" required
                                            class="shadow-sm focus:ring-primary focus:border-primary block w-full sm:text-sm border-gray-300 rounded-md @error('table_id') border-red-500 @enderror">
                                            <option value="">Sélectionnez une table</option>
                                            @foreach($tables as $table)
                                                <option value="{{ $table->id }}" {{ old('table_id') == $table->id ? 'selected' : '' }}>
                                                    Table {{ $table->number }} ({{ $table->seats }} places)
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('table_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end space-x-3">
                                <a href="{{ route('manager.reservations.index') }}" 
                                   class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    Annuler
                                </a>
                                <button type="submit" 
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    Créer la réservation
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>

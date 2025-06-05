<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Table - RestauManager</title>
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
            @include('manager.partials.header', ['title' => 'Nouvelle Table'])

            <!-- Content -->
            <main class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
                <div class="mb-6">
                    <a href="{{ route('manager.tables.index') }}" class="text-primary hover:text-amber-600">
                        <i class="fas fa-arrow-left mr-2"></i>Retour aux tables
                    </a>
                </div>

                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">
                            Créer une nouvelle table
                        </h3>

                        <form method="POST" action="{{ route('manager.tables.store') }}">
                            @csrf
                            
                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <!-- Numéro de table -->
                                <div class="sm:col-span-3">
                                    <label for="number" class="block text-sm font-medium text-gray-700">
                                        Numéro de table *
                                    </label>
                                    <div class="mt-1">
                                        <input type="number" name="number" id="number" required min="1"
                                            value="{{ old('number') }}"
                                            class="shadow-sm focus:ring-primary focus:border-primary block w-full sm:text-sm border-gray-300 rounded-md @error('number') border-red-500 @enderror">
                                    </div>
                                    @error('number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Nombre de places -->
                                <div class="sm:col-span-3">
                                    <label for="seats" class="block text-sm font-medium text-gray-700">
                                        Nombre de places *
                                    </label>
                                    <div class="mt-1">
                                        <input type="number" name="seats" id="seats" required min="1" max="20"
                                            value="{{ old('seats') }}"
                                            class="shadow-sm focus:ring-primary focus:border-primary block w-full sm:text-sm border-gray-300 rounded-md @error('seats') border-red-500 @enderror">
                                    </div>
                                    @error('seats')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end space-x-3">
                                <a href="{{ route('manager.tables.index') }}" 
                                   class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    Annuler
                                </a>
                                <button type="submit" 
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    Créer la table
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

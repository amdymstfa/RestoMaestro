<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personnel - RestauManager</title>
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
            @include('manager.partials.header', ['title' => 'Gestion du Personnel'])

            <!-- Content -->
            <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <!-- Header avec boutons d'action -->
                <div class="mb-6 flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Personnel</h1>
                        <p class="mt-1 text-sm text-gray-600">Gérez les membres de votre équipe</p>
                    </div>
                    <a href="{{ route('manager.staff.create') }}" class="bg-primary hover:bg-amber-600 text-white px-4 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-plus mr-2"></i>Nouveau membre
                    </a>
                </div>

                <!-- Filtres -->
                <div class="bg-white shadow rounded-lg mb-6">
                    <div class="p-6">
                        <form method="GET" action="{{ route('manager.staff.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700">Rôle</label>
                                <select name="role" id="role" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                                    <option value="">Tous les rôles</option>
                                    <option value="manager" {{ request('role') == 'manager' ? 'selected' : '' }}>Gérant</option>
                                    <option value="waiter" {{ request('role') == 'waiter' ? 'selected' : '' }}>Serveur</option>
                                    <option value="cook" {{ request('role') == 'cook' ? 'selected' : '' }}>Cuisinier</option>
                                </select>
                            </div>
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700">Recherche</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                    placeholder="Nom ou email..."
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium mr-2">
                                    <i class="fas fa-search mr-2"></i>Filtrer
                                </button>
                                <a href="{{ route('manager.staff.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md text-sm font-medium">
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

                <!-- Liste du personnel -->
                <div class="bg-white shadow rounded-lg">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Membre
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Téléphone
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Rôle
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Inscription
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($staff as $member)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 rounded-full bg-primary flex items-center justify-center text-white font-medium">
                                                    {{ strtoupper(substr($member->name, 0, 2)) }}
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $member->name }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $member->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $member->phone ?: '-' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $member->role == 'manager' ? 'bg-purple-100 text-purple-800' : 
                                                   ($member->role == 'waiter' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                                {{ $member->role == 'manager' ? 'Gérant' : 
                                                   ($member->role == 'waiter' ? 'Serveur' : 'Cuisinier') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $member->created_at->format('d/m/Y') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('manager.staff.show', $member) }}" 
                                                   class="text-blue-600 hover:text-blue-900">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('manager.staff.edit', $member) }}" 
                                                   class="text-primary hover:text-amber-600">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('manager.staff.destroy', $member) }}" 
                                                      class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce membre ?')">
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
                                            Aucun membre du personnel trouvé
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($staff->hasPages())
                        <div class="px-6 py-3 border-t border-gray-200">
                            {{ $staff->links() }}
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>
</body>
</html>

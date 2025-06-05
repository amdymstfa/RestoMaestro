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
    
    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const sidebarMenu = document.getElementById('sidebar-menu');
            
            if (mobileMenuButton && sidebarMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    sidebarMenu.classList.toggle('hidden');
                });
            }
        });
    </script>
</aside>

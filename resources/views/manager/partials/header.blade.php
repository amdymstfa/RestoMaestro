<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
        <h2 class="text-xl font-semibold text-gray-800">{{ $title ?? 'Dashboard Manager' }}</h2>
        <div class="flex items-center">
            <span class="mr-4 text-gray-600">{{ Auth::user()->name }}</span>
            <div class="relative">
                <button class="flex items-center focus:outline-none">
                    <div class="h-8 w-8 rounded-full bg-primary flex items-center justify-center text-white">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                </button>
            </div>
        </div>
    </div>
</header>

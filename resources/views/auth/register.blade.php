<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - RestauManager</title>
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
<body class="bg-gray-50 min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="text-center">
            <h1 class="text-3xl font-bold text-primary">🍽️ RestauManager</h1>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Créez votre compte
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Ou
                <a href="{{ route('login') }}" class="font-medium text-primary hover:text-amber-500">
                    connectez-vous à votre compte existant
                </a>
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <form class="space-y-6" action="{{ route('register') }}" method="POST">
                @csrf
                

                <!-- Full Name -->
                <div class="">
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            Nom Complet
                        </label>
                        <div class="mt-1">
                            <input id="name" name="name" type="text" required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                                placeholder="Dupont">
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Adresse email
                    </label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                            placeholder="jean.dupont@email.com">
                    </div>
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">
                        Téléphone
                    </label>
                    <div class="mt-1">
                        <input id="phone" name="phone" type="tel"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                            placeholder="06 12 34 56 78">
                    </div>
                </div>

                <!-- Role Selection -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">
                        Rôle
                    </label>
                    <div class="mt-1">
                        <select id="role" name="role" required
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                            <option value="">Sélectionnez votre rôle</option>
                            <option value="manager">👨‍💼 Gérant de restaurant</option>
                            <option value="waiter">👨‍🍳 Serveur</option>
                            <option value="cook">👩‍🍳 Cuisinier</option>
                            <option value="client">👤 Client</option>
                        </select>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">
                        Votre rôle déterminera vos accès dans l'application
                    </p>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Mot de passe
                    </label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                            placeholder="••••••••">
                    </div>
                    <div class="mt-1">
                        <div class="flex text-xs text-gray-500">
                            <span id="password-strength" class="flex-1">Minimum 8 caractères</span>
                        </div>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                        Confirmer le mot de passe
                    </label>
                    <div class="mt-1">
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                            placeholder="••••••••">
                    </div>
                    <p id="password-match" class="mt-1 text-xs text-gray-500"></p>
                </div>

                <!-- Terms and Conditions -->
                <div class="flex items-center">
                    <input id="terms" name="terms" type="checkbox" required
                        class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                    <label for="terms" class="ml-2 block text-sm text-gray-900">
                        J'accepte les
                        <a href="#" class="text-primary hover:text-amber-500">conditions d'utilisation</a>
                        et la
                        <a href="#" class="text-primary hover:text-amber-500">politique de confidentialité</a>
                    </label>
                </div>

                <!-- Submit button -->
                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-amber-300 group-hover:text-amber-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6z" />
                            </svg>
                        </span>
                        Créer mon compte
                    </button>
                </div>
            </form>

           
        <!-- Back to home -->
        <div class="mt-6 text-center">
            <a href="{{ route('home') }}" class="text-sm text-gray-600 hover:text-primary">
                ← Retour à l'accueil
            </a>
        </div>
    </div>

    <script>
        // Show restaurant field for gérant role
        document.getElementById('role').addEventListener('change', function() {
            const selectedRole = this.value;
            const restaurantField = document.getElementById('restaurant-field');
            const roleBenefits = document.getElementById('role-benefits');
            
            // Show/hide restaurant field
            if (selectedRole === 'gerant') {
                restaurantField.classList.remove('hidden');
                document.getElementById('restaurant_name').required = true;
            } else {
                restaurantField.classList.add('hidden');
                document.getElementById('restaurant_name').required = false;
            }
            
            // Show role benefits
            if (selectedRole) {
                roleBenefits.classList.remove('hidden');
                // Hide all benefits first
                document.querySelectorAll('[id$="-benefits"]').forEach(el => el.classList.add('hidden'));
                // Show selected role benefits
                const benefitsEl = document.getElementById(selectedRole + '-benefits');
                if (benefitsEl) {
                    benefitsEl.classList.remove('hidden');
                }
            } else {
                roleBenefits.classList.add('hidden');
            }
        });

        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthEl = document.getElementById('password-strength');
            
            if (password.length < 8) {
                strengthEl.textContent = 'Minimum 8 caractères';
                strengthEl.className = 'flex-1 text-red-500';
            } else if (password.length < 12) {
                strengthEl.textContent = 'Mot de passe moyen';
                strengthEl.className = 'flex-1 text-yellow-500';
            } else {
                strengthEl.textContent = 'Mot de passe fort';
                strengthEl.className = 'flex-1 text-green-500';
            }
        });

        // Password confirmation check
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmation = this.value;
            const matchEl = document.getElementById('password-match');
            
            if (confirmation === '') {
                matchEl.textContent = '';
            } else if (password === confirmation) {
                matchEl.textContent = '✓ Les mots de passe correspondent';
                matchEl.className = 'mt-1 text-xs text-green-500';
            } else {
                matchEl.textContent = '✗ Les mots de passe ne correspondent pas';
                matchEl.className = 'mt-1 text-xs text-red-500';
            }
        });
    </script>
</body>
</html>

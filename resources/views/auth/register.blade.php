<x-app-layout>
    <!-- Agregar Bootstrap CSS -->
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <head>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                /* Quitar el subrayado de todos los enlaces */
                a {
                    text-decoration: none !important;
                }
            </style>
        </head>

    </head>
    <div class="min-h-screen flex flex-col items-center pt-6 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="nombre" :value="__('Nombre')" />
                    <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')"
                        required autofocus autocomplete="nombre" />
                    <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                <!-- Apellido paterno -->
                <div class="mt-4">
                    <x-input-label for="apellido_paterno" :value="__('Apellido paterno')" />
                    <x-text-input id="apellido_paterno" class="block mt-1 w-full" type="text" name="apellido_paterno"
                        :value="old('apellido_paterno')" autofocus autocomplete="apellido_paterno" />
                    <x-input-error :messages="$errors->get('apellido_paterno')" class="mt-2" />
                </div>

                <!-- Apellido materno -->
                <div class="mt-4">
                    <x-input-label for="apellido_materno" :value="__('Apellido materno')" />
                    <x-text-input id="apellido_materno" class="block mt-1 w-full" type="text" name="apellido_materno"
                        :value="old('apellido_materno')" autofocus autocomplete="apellido_materno" />
                    <x-input-error :messages="$errors->get('apellido_materno')" class="mt-2" />
                </div>
                
                <div class="mt-4">
                    <x-input-label for="departamento" :value="__('Departamento')" />
                    <div class="relative">
                        <select name="departamento" id="departamento"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            @foreach ($departamentos as $departamento)
                                <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <x-input-error :messages="$errors->get('departamento')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label :value="__('Tipo de usuario')" />
                    <div class="flex space-x-4 mt-2">
                        <label class="flex items-center">
                            <input type="radio" name="tipo_usuario" value="1"
                                class="form-radio h-4 w-4 text-indigo-600" onchange="toggleRoles()" />
                            <span class="ml-2 text-gray-700">Docente</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="tipo_usuario" value="2"
                                class="form-radio h-4 w-4 text-indigo-600" onchange="toggleRoles()" />
                            <span class="ml-2 text-gray-700">Administrativo</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="tipo_usuario" value="3"
                                class="form-radio h-4 w-4 text-indigo-600" onchange="toggleRoles()" />
                            <span class="ml-2 text-gray-700">Otro</span>
                        </label>
                    </div>
                    <x-input-error :messages="$errors->get('tipo_usuario')" class="mt-2" />
                </div>

                <!-- Role Selection -->
                <div class="mt-4" id="roles-container">
                    <x-input-label for="roles" :value="__('Rol')" />
                    <div class="mt-2">
                        @foreach ($roles as $role)
                            @if ($role->nombre != 'admin')
                                <label class="block mb-2 role-option">
                                    <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                        class="form-checkbox h-4 w-4 text-indigo-600" />
                                    <span class="ml-2 text-gray-100">{{ $role->nombre }}</span>
                                </label>

                            @endif
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('roles')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Correo')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Contraseña')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                        name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                        href="{{ route('login') }}">
                        {{ __('¿Ya estas registrado?') }}
                    </a>

                    <x-primary-button class="ml-4">
                        {{ __('Registrar') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
    <script>
        // Función para controlar la visibilidad de los roles
        function toggleRoles() {
            const tipoUsuario = document.querySelector('input[name="tipo_usuario"]:checked').value;
            const rolesContainer = document.getElementById('roles-container');
            const roleOptions = rolesContainer.querySelectorAll('.role-option');

            // Primero, desmarcar todos los checkboxes
            roleOptions.forEach(option => {
                const checkbox = option.querySelector('input');
                checkbox.checked = false; // Desmarcar checkbox
                option.style.display = 'none'; // Ocultar opción
            });

            // Mostrar roles dependiendo del tipo de usuario
            if (tipoUsuario == '1') { // Docente
                roleOptions.forEach(option => option.style.display = 'block');
            } else if (tipoUsuario == '2') { // Administrativo
                roleOptions.forEach(option => {
                    const roleId = option.querySelector('input').value;
                    if (roleId == '2' || roleId == '5') { // Jefe de departamento e Instructor
                        option.style.display = 'block';
                    }
                });
            } else if (tipoUsuario == '3') { // Otro
                roleOptions.forEach(option => {
                    const roleId = option.querySelector('input').value;
                    if (roleId == '5') { // Instructor
                        option.style.display = 'block';
                    }
                });
            }
        }

        // Ejecutar la función al cargar la página
        window.onload = toggleRoles;
    </script>
</x-app-layout>

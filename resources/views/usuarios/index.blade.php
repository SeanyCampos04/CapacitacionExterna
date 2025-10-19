<x-app-layout>
    <!-- Agregar Bootstrap CSS -->
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            /* Quitar el subrayado de todos los enlaces */
            a {
                text-decoration: none !important;
            }
        </style>
    </head>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">
            {{ __('Usuarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Buscador -->
                <form method="GET" action="{{ route('usuarios.index') }}" class="mb-6">
                    <div class="flex items-center justify-between gap-2">
                        <input
                            type="text"
                            name="busqueda"
                            value="{{ old('busqueda', $busqueda ?? '') }}"
                            placeholder="Buscar por nombre, email o departamento..."
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        >
                        <button
    type="submit"
    class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold py-2 px-4 rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-blue-500">
    Buscar
</button>
                    </div>
                </form>


                <!-- Tabla -->
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xm text-gray-700 bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center">Nombre</th>
                                <th scope="col" class="px-6 py-3 text-center">Email</th>
                                <th scope="col" class="px-6 py-3 text-center">Departamento</th>
                                <th scope="col" class="px-6 py-3 text-center">Estatus</th>
                                <th scope="col" class="px-6 py-3 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($usuarios as $usuario)
                                <tr class="bg-white border-b">
                                    <td class="text-center">
                                        {{ $usuario->datos_generales->nombre }}
                                        {{ $usuario->datos_generales->apellido_paterno }}
                                        {{ $usuario->datos_generales->apellido_materno }}
                                    </td>
                                    <td class="text-center">{{ $usuario->email }}</td>
                                    <td class="text-center">{{ $usuario->datos_generales->departamento->nombre ?? '—' }}</td>
                                    <td class="text-center">
                                        {{ $usuario->estatus ? 'Activo' : 'Inactivo' }}
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('usuario_datos.index', $usuario->id) }}" method="GET">
                                            @csrf
                                            @method('GET')
                                            <x-primary-button
                                                class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-0 text-white">
                                                Ver detalles
                                            </x-primary-button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-gray-500">
                                        No se encontraron usuarios.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>
</x-app-layout>

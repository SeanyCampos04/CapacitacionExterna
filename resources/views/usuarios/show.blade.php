<x-app-layout>
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lista de Capacitaciones Externas</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background-color: #f8f9fa;
            }

            .container {
                margin-top: 50px;
                max-width: 1200px;
                background-color: #ffffff;
                border-radius: 8px;
                box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
                padding: 20px;
            }

            h2 {
                text-align: center;
                margin-bottom: 30px;
                font-size: 24px;
            }

            .table-responsive {
                margin-top: 20px;
                overflow-x: auto;
            }

            table {
                width: 100%;
            }

            thead {
                background-color: #ffffff;
                color: white;
            }

            th,
            td {
                text-align: center;
                vertical-align: middle;
                white-space: nowrap;
            }

            .delete-btn {
                margin-left: 10px;
            }

            a {
                text-decoration: none !important;
            }
        </style>
    </head>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">
            {{ __('Detalles del usuario:') }} {{ $usuario->datos_generales->nombre }}
            {{ $usuario->datos_generales->apellido_paterno }} {{ $usuario->datos_generales->apellido_materno }}
        </h2>
    </x-slot>

    <div class="container mt-6 mx-auto">
        <div class="flex flex-wrap justify-center">
            <div class="mb-4 mx-2 w-full md:w-1/2 lg:w-1/3 xl:w-1/4">
                <div class="bg-white rounded-lg overflow-hidden shadow-md h-full">
                    <div class="p-4">
                        <h5 class="text-xl font-semibold">{{ $usuario->datos_generales->nombre }}
                            {{ $usuario->datos_generales->apellido_paterno }}
                            {{ $usuario->datos_generales->apellido_materno }}</h5>
                        <h6 class="text-sm font-semibold text-gray-700 mb-2"><strong>Email:</strong>
                            {{ $usuario->email }}</h6>
                        <p class="text-sm text-gray-700"><strong>Roles:</strong>
                            @foreach ($usuario->user_roles as $userRole)
                                {{ $userRole->nombre }},
                            @endforeach
                        </p>
                        @if ($usuario->tipo == 1)
                            <p class="text-sm text-gray-700"><strong>Tipo:</strong>Docente</p>
                        @endif
                        @if ($usuario->tipo == 2)
                            <p class="text-sm text-gray-700"><strong>Tipo:</strong>Administrativo</p>
                        @endif
                        @if ($usuario->tipo == 3)
                            <p class="text-sm text-gray-700"><strong>Tipo:</strong>Otro</p>
                        @endif
                        @if ($usuario->estatus == 1)
                            <p class="text-sm text-gray-700"><strong>Estatus:</strong>Activo</p>
                        @endif
                        @if ($usuario->estatus == 0)
                            <p class="text-sm text-gray-700"><strong>Estatus:</strong>Inactivo</p>
                        @endif
                        @if ($usuario->datos_generales->departamento->nombre)
                            <p class="text-sm text-gray-700"><strong>Departamento:</strong>
                                {{ $usuario->datos_generales->departamento->nombre }}</p>
                        @endif
                        @if ($usuario->datos_generales->fecha_nacimiento)
                            <p class="text-sm text-gray-700"><strong>Fecha nacimiento:</strong>
                                {{ $usuario->datos_generales->fecha_nacimiento }}</p>
                        @endif
                        @if ($usuario->datos_generales->curp)
                            <p class="text-sm text-gray-700"><strong>curp:</strong>
                                {{ $usuario->datos_generales->curp }}</p>
                        @endif
                        @if ($usuario->datos_generales->rfc)
                            <p class="text-sm text-gray-700"><strong>rfc:</strong> {{ $usuario->datos_generales->rfc }}
                            </p>
                        @endif
                        @if ($usuario->datos_generales->telefono)
                            <p class="text-sm text-gray-700"><strong>Telefono:</strong>
                                {{ $usuario->datos_generales->telefono }}</p>
                        @endif
                        @if ($usuario->datos_generales->sexo)
                            <p class="text-sm text-gray-700">
                                <strong>Sexo:</strong>{{ $usuario->datos_generales->sexo }}</p>
                        @endif

                        <div class="grid grid-cols-3 gap-4 w-full max-w-[400px]">
                            @if (in_array('admin', $user_roles) or in_array('CAD', $user_roles))
                                <form action="{{ route('usuario.edit', $usuario->id) }}" method="POST" class="w-full">
                                    @csrf
                                    @method('GET')
                                    <x-primary-button
                                        class="common-button bg-blue-600 text-white hover:bg-blue-700 active:bg-red-800 focus:outline-none focus:ring-0">Editar</x-primary-button>
                                </form>
                                @if ($usuario->estatus == 1)
                                    <form action="{{ route('usuario.desactivar', $usuario->id) }}" method="POST"
                                        class="w-full">
                                        @csrf
                                        @method('PUT')
                                        <x-primary-button
                                            class="common-button bg-red-600 text-white hover:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-0"
                                            onclick="return confirm('¿Estás seguro de que quieres poner como inactivo a este usuario?');">Desactivar</x-primary-button>
                                    </form>
                                @else
                                    <form action="{{ route('usuario.activar', $usuario->id) }}" method="POST"
                                        class="w-full">
                                        @csrf
                                        @method('PUT')
                                        <x-primary-button
                                            class="common-button bg-green-600 text-white hover:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-0"
                                            onclick="return confirm('¿Estás seguro de que quieres poner como activo a este usuario?');">Activar</x-primary-button>
                                    </form>
                                @endif
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <h1 class="text-center text-xl"><strong>Historial de capacitaciones</strong></h1>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="table-responsive">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xm text-gray-700 bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center">Correo</th>
                                <th scope="col" class="px-6 py-3 text-center">Nombre Completo</th>
                                <th scope="col" class="px-6 py-3 text-center">Tipo de Capacitación</th>
                                <th scope="col" class="px-6 py-3 text-center">Nombre de la Capacitación</th>
                                <th scope="col" class="px-6 py-3 text-center">Fecha Inicio</th>
                                <th scope="col" class="px-6 py-3 text-center">Fecha Termino</th>
                                <th scope="col" class="px-6 py-3 text-center">Año</th>
                                <th scope="col" class="px-6 py-3 text-center">Organismo</th>
                                <th scope="col" class="px-6 py-3 text-center">Horas</th>
                                <th scope="col" class="px-6 py-3 text-center">Evidencia</th>
                                <th scope="col" class="px-6 py-3 text-center">Comentarios</th> <!-- Nueva columna para el estado -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($capacitaciones as $capacitacion)
                                <tr class="bg-white border-b">
                                    <td class="text-center">{{ $capacitacion->correo }}</td>
                                    <td class="text-center">{{ $capacitacion->nombre }} {{ $capacitacion->apellido_paterno }} {{ $capacitacion->apellido_materno }}</td>
                                    <td class="text-center">{{ $capacitacion->tipo_capacitacion }}</td>
                                    <td class="text-center">{{ $capacitacion->nombre_capacitacion }}</td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($capacitacion->fecha_inicio)->format('d/m/Y') }}</td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($capacitacion->fecha_termino)->format('d/m/Y') }}</td>
                                    <td class="text-center">{{ $capacitacion->anio }}</td>
                                    <td class="text-center">{{ $capacitacion->organismo }}</td>
                                    <td class="text-center">{{ $capacitacion->horas }}</td>
                                    <td class="text-center">
                                        @if($capacitacion->evidencia)
                                            <a href="{{ asset('storage/' . $capacitacion->evidencia) }}" target="_blank">Ver PDF</a>
                                        @else
                                            No disponible
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <!-- Mostrar el estado de la capacitación -->
                                        @if($capacitacion->status)
                                            {{ $capacitacion->status }}
                                        @else
                                            Ninguno
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

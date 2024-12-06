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
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xm text-gray-700 bg-gray-50">
                            <tr>
                            @if($tipo_usuario == 1) <!-- Verifica si no es docente para mostrar las acciones -->
                                @if (in_array('admin', $user_roles) or in_array('CAD', $user_roles))
                                    <th scope="col" class="px-6 py-3 text-center">Acciones</th>
                                @endif
                            @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($capacitaciones as $capacitacion)
                            <tr class="bg-white border-b">
                                @if($tipo_usuario == 1) <!-- Verifica si no es docente para mostrar las acciones -->
                                    @if (in_array('admin', $user_roles) or in_array('CAD', $user_roles))
                                        <td class="text-center">
                                            <!-- Mostrar campo de "Número de Registro" y botones de acción solo si no es un docente -->
                                            <form action="{{ route('capacitacionesext.actualizarStatus', $capacitacion->id) }}" method="POST">
                                                @csrf
                                                <input type="text" name="numero_registro" class="form-control mb-2" placeholder="No. Registro" style="display:inline; width:120px;">
                                                <x-primary-button  style="background-color: #16A34A; hover: background-color: #15803D;" type="submit" class="bg-green-600 hover:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-0" name="action" value="numero_registro">Guardar
                                                </x-primary-button>

                                                <x-primary-button style="background-color: #FACC15; hover: background-color: #EAB308;"
                                                type="submit" class="bg-yellow-600 hover:bg-yellow-700 active:bg-yellow-800 focus:outline-none focus:ring-0" name="rechazado" value="rechazado">Rechazar
                                                </x-primary-button>
                                            </form>
                                        </td>
                                    @endif    
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

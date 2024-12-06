<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Inicio') }}
        </h2>
    </x-slot>

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
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Bienvenido") }}
                </div>
            </div>

            <!-- Modal centrado verticalmente -->
            <div class="modal" id="successModal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                    
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Éxito</h4>
                        </div>
                    
                        <!-- Modal body -->
                        <div class="modal-body">
                            @if(session('success'))
                                {{ session('success') }}
                            @else
                                Modal body..
                            @endif
                        </div>
                    
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <x-primary-button type="button" class="bg-green-600 hover:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-0" data-bs-dismiss="modal">
                                Cerrar
                            </x-primary-button>
                        </div>
                    
                    </div>
                </div>
            </div>

            <!-- Mensaje de error -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>

    <!-- Pie de página -->
    <footer class="bg-white dark:bg-gray-500 text-gray-500 dark:text-gray-100 mt-6">
        <div class="max-w-7xl mx-auto py-2 px-2 sm:px-4 lg:px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="font-semibold text-lg">Dirección:</h3>
                    <p>Carr. al Ingenio Plan de Ayala Km. 2, Col. Vista Hermosa. Cd. Valles. S.L.P. C.P. 79010</p>
                    <h3 class="font-semibold text-lg mt-4">Contacto:</h3>
                    <p>Departamento de Desarrollo Académico</p>
                    <p>Tel. 481 381 20 44 Ext. 132</p>
                </div>
                <div>
                    <h3 class="font-semibold text-lg">Ubicación:</h3>
                    <!-- Mapa de Google Maps -->
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3721.6645461376265!2d-98.98472152404024!3d21.980612884954716!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d7c1037fe54e79%3A0x3209c0c2b07468fd!2sInstituto%20Tecnol%C3%B3gico%20de%20Cd.%20Valles!5e0!3m2!1ses-419!2smx!4v1696459101234!5m2!1ses-419!2smx" 
                        width="100%" 
                        height="250" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </footer>

    <!-- Agregar Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Mostrar el modal automáticamente si hay un mensaje de éxito -->
    @if(session('success'))
        <script>
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        </script>
    @endif
</x-app-layout>

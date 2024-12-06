<nav>
    <ul class="flex space-x-4 bg-gray-800 p-4 text-white">
        {{-- Mostrar solo a los administradores --}}
        @if(Auth::check() && Auth::user()->user_type === 'admin')
            <li><a href="{{ route('register.user') }}" class="hover:underline">Registrar Usuarios</a></li>
            <li><a href="{{ route('formulario') }}" class="hover:underline">Registrar Capacitación</a></li>
            <li><a href="{{ route('datos') }}" class="hover:underline">Visualizar Capacitaciones</a></li>
        @endif

        {{-- Mostrar a admin y cad --}}
        @if(Auth::check() && (Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'cad'))
            <li><a href="{{ route('formulario') }}" class="hover:underline">Registrar Capacitación</a></li>
            <li><a href="{{ route('datos') }}" class="hover:underline">Visualizar Capacitaciones</a></li>
        @endif
    </ul>
</nav>
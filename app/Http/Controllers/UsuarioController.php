<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Departamento;
use App\Models\Role;
use App\Models\Participante;
use App\Models\RegistroCapacitacionesExt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    // Recoge el valor del input (busqueda)
    $busqueda = $request->input('busqueda');

    // Cargamos las relaciones para evitar N+1
    $usuarios = User::with(['datos_generales.departamento'])
        ->when($busqueda, function ($query, $busqueda) {
            $query->where(function ($q) use ($busqueda) {
                $q->where('email', 'like', "%{$busqueda}%")
                  ->orWhereHas('datos_generales', function ($sub) use ($busqueda) {
                      $sub->where('nombre', 'like', "%{$busqueda}%")
                          ->orWhere('apellido_paterno', 'like', "%{$busqueda}%")
                          ->orWhere('apellido_materno', 'like', "%{$busqueda}%")
                          ->orWhereHas('departamento', function ($d) use ($busqueda) {
                              $d->where('nombre', 'like', "%{$busqueda}%");
                          });
                  });
            });
        })
        ->get();

    // Retornamos la vista con la variable $busqueda (para que se mantenga en el input)
    return view('usuarios.index', compact('usuarios', 'busqueda'));
}


    public function show($id)
    {
        $usuario = User::find($id);
        $participante = Participante::find($id);
        $capacitaciones = RegistroCapacitacionesExt::where('correo', $usuario->email)->get();

        return view('usuarios.show', compact('usuario', 'capacitaciones'));
    }

    public function edit(string $id)
    {
        $usuario = User::find($id);
        $departamentos = Departamento::all();
        $roles = Role::all();

        return view('usuarios.edit', compact('usuario', 'departamentos', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidoP' => 'nullable|string|max:255',
            'apellidoM' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'curp' => 'nullable|string|max:18',
            'rfc' => 'nullable|string|max:13',
            'telefono' => 'nullable|string|max:15',
            'departamento' => 'required|exists:departamentos,id',
            'tipo_usuario' => 'required|integer|in:1,2,3',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $usuario = User::findOrFail($id);

        $usuario->email = $validated['email'];
        $usuario->tipo = $validated['tipo_usuario'];

        if ($request->filled('password')) {
            $usuario->password = Hash::make($validated['password']);
        }
        $usuario->save();

        $datosGenerales = $usuario->datos_generales;
        $datosGenerales->nombre = $validated['nombre'];
        $datosGenerales->apellido_paterno = $validated['apellidoP'];
        $datosGenerales->apellido_materno = $validated['apellidoM'];
        $datosGenerales->fecha_nacimiento = $validated['fecha_nacimiento'];
        $datosGenerales->curp = $validated['curp'];
        $datosGenerales->rfc = $validated['rfc'];
        $datosGenerales->telefono = $validated['telefono'];
        $datosGenerales->departamento_id = $validated['departamento'];
        $datosGenerales->save();

        $role_instructor = Role::where('nombre', 'Instructor')->first();

        if ($request->filled('roles')) {
            $usuario->roles()->sync($validated['roles']);

            if (in_array($role_instructor->id, $validated['roles'])) {
                if (!$usuario->instructor()->exists()) {
                    $usuario->instructor()->create([
                        'user_id' => $usuario->id
                    ]);
                }
            }
        } else {
            $usuario->roles()->detach();
        }

        return Redirect::route('usuario_datos.index', $usuario->id)->with('status', 'profile-updated');
    }

    public function activar($id)
    {
        $usuario = User::find($id);
        $usuario->estatus = true;
        $usuario->save();
        return redirect(route('usuarios.index'));
    }

    public function desactivar($id)
    {
        $usuario = User::find($id);
        $usuario->estatus = false;
        $usuario->save();
        return redirect(route('usuarios.index'));
    }
}

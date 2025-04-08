<?php

namespace App\Http\Controllers\Modulos;

use App\Http\Controllers\Controller;
use App\Models\Empleados;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Inertia\Inertia;

class EmpleadosController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:empleados-listar|empleados-crear|empleados-editar|empleados-eliminar', only: ['index', 'store']),
            new Middleware('permission:empleados-crear', only: ['create', 'store']),
            new Middleware('permission:empleados-editar', only: ['edit', 'update']),
            new Middleware('permission:empleados-eliminar', only: ['destroy']),
        ];
    }
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $estado = $request->input('estado', 1);

        $empleados = Empleados::orderBy('id', 'DESC')
            ->when($estado !== null, function ($query) use ($estado) {
                $query->where('estado', $estado);
            })
            ->paginate($perPage)
            ->withQueryString();

        return Inertia::render('empleados/Index', [
            'empleados' => $empleados,
            'per_page' => $perPage
        ]);
    }

    public function create()
    {
        return Inertia::render('empleados/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'tipo_doc' => 'required',
            'documento' => 'required',
            'email' => 'required|email',
            'telefono' => 'required',
            'direccion' => 'required',
            'cargo' => 'required',
            'departamento' => 'required',
            'fecha_nacimiento' => 'required|date',
        ]);

        // Convertir la fecha al formato correcto antes de actualizar
        $data = $request->all();
        $data['fecha_nacimiento'] = date('Y-m-d', strtotime($request->fecha_nacimiento));
        Empleados::create($data);

        return redirect()->route('empleados.index');
    }

    public function edit($id)
    {
        $empleado = Empleados::find($id);

        return Inertia::render('empleados/Edit', compact('empleado'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'tipo_doc' => 'required',
            'documento' => 'required',
            'email' => 'required|email',
            'telefono' => 'required',
            'direccion' => 'required',
            'cargo' => 'required',
            'departamento' => 'required',
            'fecha_nacimiento' => 'required|date',
        ]);

        $empleado = Empleados::findOrFail($id);

        // Convertir la fecha al formato correcto antes de actualizar
        $data = $request->all();
        $data['fecha_nacimiento'] = date('Y-m-d', strtotime($request->fecha_nacimiento));

        $empleado->update($data);

        return redirect()->route('empleados.index');
    }


    public function destroy($id)
    {
        try {
            $empleado = Empleados::find($id);
            $empleado->update(['estado' => 0]);
        } catch (\Exception $e) {
            return redirect()->route('empleados.index')->with('error', 'No se puede eliminar el empleado porque tiene registros asociados.');
        }
        return redirect()->route('empleados.index');
    }
}

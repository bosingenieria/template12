<?php

namespace App\Http\Controllers\Modulos;

use App\Http\Controllers\Controller;
use App\Models\Clientes;
use App\Models\Empleados;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Inertia\Inertia;

class ClientesController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:clientes-listar|clientes-crear|clientes-editar|clientes-eliminar', only: ['index', 'store']),
            new Middleware('permission:clientes-crear', only: ['create', 'store']),
            new Middleware('permission:clientes-editar', only: ['edit', 'update']),
            new Middleware('permission:clientes-eliminar', only: ['destroy']),
        ];
    }
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $estado = $request->input('estado', 1);
        $search = $request->input('search');

        $clientes = Clientes::orderBy('id', 'DESC')
            ->when($estado !== null, function ($query) use ($estado) {
                $query->where('estado', $estado);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nombre', 'like', "%{$search}%")
                      ->orWhere('apellido', 'like', "%{$search}%") // Buscar por apellido
                      ->orWhere('documento_identidad', 'like', "%{$search}%");
                });
            })
            ->paginate($perPage)
            ->withQueryString();

        return Inertia::render('clientes/Index', [
            'clientes' => $clientes,
            'per_page' => $perPage
        ]);
    }


    public function create()
    {
        return Inertia::render('clientes/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'tipo_doc' => 'required',
            'documento_identidad' => 'required|string|max:20|unique:clientes,documento_identidad',
            'email' => 'required|email',
            'telefono_principal' => 'required',
            'direccion_principal' => 'required',
        ]);

        Clientes::create($request->all());

        return redirect()->route('clientes.index');
    }

    public function edit($id)
    {
        $cliente = Clientes::find($id);

        return Inertia::render('clientes/Edit', compact('cliente'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'tipo_doc' => 'required',
            'documento_identidad' => 'required|string|max:20|unique:clientes,documento_identidad,' . $id,
            'email' => 'required|email',
            'telefono_principal' => 'required',
            'direccion_principal' => 'required',
        ]);



        $cliente = Clientes::findOrFail($id);

        $cliente->update(
            [
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'tipo_doc' => $request->tipo_doc,
                'documento_identidad' => $request->documento_identidad,
                'email' => $request->email,
                'telefono_principal' => $request->telefono_principal,
                'telefono_secundario' => $request->telefono_secundario,
                'direccion_principal' => $request->direccion_principal,
                'direccion_secundaria' => $request->direccion_secundaria,
                'estado' => $request->estado ? 1 : 0,
            ]
        );

        return redirect()->route('clientes.index');
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

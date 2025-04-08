<?php

namespace App\Http\Controllers\Modulos;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UsuariosController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:usuarios-listar|usuarios-crear|usuarios-editar|usuarios-eliminar', only: ['index', 'store']),
            new Middleware('permission:usuarios-crear', only: ['create', 'store']),
            new Middleware('permission:usuarios-editar', only: ['edit', 'update']),
            new Middleware('permission:usuarios-eliminar', only: ['destroy']),
        ];
    }
    public function index(Request $request)
    {

        $perPage = $request->input('per_page', 10);

        $users = User::with('roles')->orderBy('id', 'DESC')->paginate($perPage)->withQueryString();

        dd($users->toArray());
        return Inertia::render('usuarios/Index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return Inertia::render('usuarios/Create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|string|unique:users,email',
            'password' => 'required|string|min:8',
            'roles_user' => 'required'
        ]);

        $request->merge([
            'password' => Hash::make($request->password),
        ]);

        $user = User::create($request->all());
        $user->syncRoles($request->roles);

        return redirect()->route('usuarios.index');
    }

    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $usuario->roles->pluck('name', 'name')->all();

        dd($usuario->toArray());
        return Inertia::render('usuarios/Edit', compact('usuario', 'roles', 'userRole'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|string|unique:users,email,' . $id,
            'roles_user' => 'required'
        ]);

        $user = User::findOrFail($id);
        $user->update($request->all());
        $user->syncRoles($request->roles_user);

        return redirect()->route('usuarios.index');
    }

    public function destroy($id)
    {
        try {
            User::find($id)->delete();
        } catch (\Exception $e) {
            return redirect()->route('usuarios.index')->with('error', 'No se puede el usuario tiene registros asociados.');
        }
        return redirect()->route('usuarios.index');
    }
}

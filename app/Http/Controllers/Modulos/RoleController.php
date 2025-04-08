<?php

namespace App\Http\Controllers\Modulos;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:rol-listar|rol-crear|rol-editar|rol-eliminar', only: ['index', 'store']),
            new Middleware('permission:rol-crear', only: ['create', 'store']),
            new Middleware('permission:rol-editar', only: ['edit', 'update']),
            new Middleware('permission:rol-eliminar', only: ['destroy']),
        ];
    }
    public function index(Request $request)
    {
        return Inertia::render('roles/Index', [
            'roles' => Role::orderBy('id', 'DESC')->get()
        ]);
    }

    public function create()
    {
        $permission = Permission::pluck('name')->all();
        return Inertia::render('roles/Create', compact('permission'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles',
            'permisos' => 'required',
        ]);

        $role = Role::create($request->all());
        $role->syncPermissions($request->input('permisos'));

        return redirect()->route('roles.index');
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::pluck('name')->all();
        $rolePermissions = $role->permissions()->pluck('name')->all();

        return Inertia::render('roles/Edit', compact('role', 'permission', 'rolePermissions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
            'permisos' => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
        $role->syncPermissions($request->input('permisos'));

        // 🔥 Eliminar caché de todos los usuarios con este rol
        $users = $role->users; // Obtiene los usuarios con este rol
        foreach ($users as $user) {
            Cache::forget("user_permissions_{$user->id}");
        }

        return back();
    }

    public function destroy($id)
    {
        $role = Role::find($id);
        $role->delete();
        return redirect()->route('roles.index');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index', ['roles' => $roles]);
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(StoreRoleRequest $request)
    {
        $r = $request->validated();

        Role::create($r);
        return redirect(route('admin.roles.index'));
    }

    public function edit(Role $role)
    {
        return view('admin.roles.edit', ['role' => $role]);
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $r = $request->validated();

        $role->update(
            [
                'name' => $r['newName'],
                'priority' => $r['newPriority']
            ]
        );

        return redirect(route('admin.roles.index'));
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect(route('admin.roles.index'));
    }
}

<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\RoleRequest;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use App\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Role::class);
    }

    public function index()
    {
        return view('backend.roles.index');
    }

    public function create()
    {
        return view('backend.roles.create');
    }

    public function store(RoleRequest $request)
    {
        $data = $request->validated();
        $exists = Role::query()
            ->where('name', $data['name'])
            ->exists();
        if ($exists) {
            throw ValidationException::withMessages([
                'name' => __('validation.unique', ['attribute' => 'name']),
            ]);
        }
        /** @var Role $role */
        $role = Role::query()->create($data);
        $role->syncPermissions(Permission::query()->whereIn('id', $data['permissions'] ?? [])->get());
        flash()->success(__('Role ":name" has been added to system.', ['name' => $role->name]));

        return redirect()->route('backend.roles.show', $role);
    }

    public function show(Role $role)
    {
        return view('backend.roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        return view('backend.roles.edit', compact('role'));
    }

    public function update(RoleRequest $request, Role $role)
    {
        $data = $request->validated();
        $exists = Role::query()
            ->where('name', $data['name'])
            ->whereKeyNot($role->getKey())
            ->exists();
        if ($exists) {
            throw ValidationException::withMessages([
                'name' => __('validation.unique', ['attribute' => 'name']),
            ]);
        }
        $role->fill($data);
        $role->save();
        $role->syncPermissions(Permission::query()->whereIn('id', $data['permissions'] ?? [])->get());
        flash()->success(__('Role ":name" information has been updated.', ['name' => $role->name]));

        return redirect()->route('backend.roles.show', $role);
    }

    public function destroy(Role $role)
    {
        $role->delete();
        flash()->info(__('Role ":name" has been deleted from system.', ['name' => $role->name]));

        return redirect()->route('backend.roles.index');
    }
}

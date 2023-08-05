<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleCreateOrUpdateRequest;
use App\Models\Role;
use Illuminate\Validation\ValidationException;
use Quarks\Laravel\Locking\LockedVersionMismatchException;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Role::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleCreateOrUpdateRequest $request)
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

        return redirect()->route('roles.show', $role);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleCreateOrUpdateRequest $request, Role $role)
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
        $role->fillLockVersion();
        try {
            $role->save();
        } catch (LockedVersionMismatchException) {
            flash()->warning(__('This role was already modified elsewhere.'));
            throw ValidationException::withMessages([]);
        }

        $role->syncPermissions(Permission::query()->whereIn('id', $data['permissions'] ?? [])->get());
        flash()->success(__('Role ":name" information has been updated.', ['name' => $role->name]));

        return redirect()->route('roles.show', $role);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        flash()->info(__('Role ":name" has been deleted from system.', ['name' => $role->name]));

        return redirect()->route('backend.roles.index');
    }
}

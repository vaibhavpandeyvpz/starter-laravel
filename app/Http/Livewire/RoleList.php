<?php

namespace App\Http\Livewire;

use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class RoleList extends Component
{
    public string $permission = '';

    public function render()
    {
        $query = Role::query();
        if ($this->q) {
            $query = $query->where(function ($query) {
                /** @var Builder $query */
                $query->where('name', 'like', "%$this->q%");
            });
        }

        if ($this->permission) {
            $query = $query->whereHas('permissions', function ($query) {
                /** @var Builder $query */
                $query->whereKey($this->permission);
            });
        }

        foreach ($this->order as $column => $direction) {
            $query = $query->orderBy($column, $direction);
        }

        $roles = $query->paginate($this->length);
        $permissions = Permission::all();

        return view('livewire.role-list', compact('permissions', 'roles'));
    }
}

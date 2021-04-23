<?php

namespace App\Http\Livewire\Backend;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class RolesList extends Component
{
    use WithPagination;

    public $length = '10';

    public $order = ['created_at' => 'desc'];

    public $q;

    public $permission;

    public function render()
    {
        $roles = Role::query();
        if ($this->q) {
            $roles = $roles->where('name', 'like', "%$this->q%");
        }

        if ($this->permission) {
            $roles->whereHas('permissions', function ($query) {
                $query->whereKey($this->permission);
            });
        }

        foreach ($this->order as $column => $direction) {
            $roles = $roles->orderBy($column, $direction);
        }

        $roles = $roles->paginate($this->length);
        return view('livewire.backend.roles-list', compact('roles'));
    }

    public function updatingLength()
    {
        $this->resetPage();
    }

    public function updatingPermission()
    {
        $this->resetPage();
    }

    public function updatingQ($q)
    {
        $this->resetPage();
    }

    /**
     * @param string $column
     * @param string|false $direction
     */
    public function sort($column, $direction)
    {
        if ($direction) {
            $this->order[$column] = $direction;
        } else {
            unset($this->order[$column]);
        }

        $this->resetPage();
    }
}

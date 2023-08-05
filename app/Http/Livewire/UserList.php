<?php

namespace App\Http\Livewire;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class UserList extends Component
{
    use WithDataTable;

    public string $role = '';

    public string $enabled = '';

    public function render()
    {
        $query = User::query();
        if ($this->q) {
            $query = $query->where(function ($query) {
                /** @var Builder $query */
                $query->where('name', 'like', "%$this->q%")
                    ->orWhere('email', 'like', "%$this->q%");
            });
        }

        if ($this->role === '0') {
            $query = $query->whereDoesntHave('roles');
        } elseif ($this->role) {
            $query = $query->whereHas('roles', function ($query) {
                /** @var Builder $query */
                $query->whereKey($this->role);
            });
        }

        if ($this->enabled !== '') {
            $query = $query->where('enabled', $this->enabled === '1');
        }

        foreach ($this->order as $column => $direction) {
            $query = $query->orderBy($column, $direction);
        }

        $users = $query->paginate($this->length);
        $roles = Role::all();

        return view('livewire.user-list', compact('roles', 'users'));
    }
}

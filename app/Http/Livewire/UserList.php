<?php

namespace App\Http\Livewire;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class UserList extends Component
{
    use WithDataTable {
        filter as applyFilter;
    }

    public string $role = '';

    public string $enabled = '';

    public string $fromDate = '';

    public string $toDate = '';

    public function filter(): void
    {
        $this->applyFilter();
        if ($this->filtering) {
            $this->emit('filteringEnabled');
        }
    }

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

        if ($this->fromDate) {
            $query = $query->whereDate('created_at', '>=', $this->fromDate);
        }

        if ($this->toDate) {
            $query = $query->whereDate('created_at', '<=', $this->toDate);
        }

        foreach ($this->order as $column => $direction) {
            $query = $query->orderBy($column, $direction);
        }

        $users = $query->paginate($this->length);
        $roles = Role::all();

        return view('livewire.user-list', compact('roles', 'users'));
    }
}

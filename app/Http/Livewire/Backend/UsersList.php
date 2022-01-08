<?php

namespace App\Http\Livewire\Backend;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;
use App\Role;

class UsersList extends Component
{
    use WithPagination;

    public $enabled;

    public $filtering = false;

    public $length = '10';

    public $order = ['created_at' => 'desc'];

    public $role;

    public $search;

    public function filter()
    {
        $this->filtering = !$this->filtering;
    }

    public function render()
    {
        $query = User::query();
        if ($this->search) {
            $query->where(function (Builder $query) {
                $query->where('name', 'like', "%$this->search%")
                    ->orWhere('email', 'like', "%$this->search%");
            });
        }

        if ($this->role && Gate::check('viewAny', Role::class)) {
            $query->whereHas('roles', function ($query) {
                $query->whereKey($this->role);
            });
        }

        if ($this->enabled) {
            $query->where('enabled', $this->enabled === 'true');
        }

        foreach ($this->order as $column => $direction) {
            $query->orderBy($column, $direction);
        }

        $users = $query->paginate($this->length);

        return view('livewire.backend.users-list', compact('users'));
    }

    /**
     * @param string $column
     * @param string|false $direction
     */
    public function sort(string $column, $direction)
    {
        if ($direction) {
            $this->order[$column] = $direction;
        } else {
            unset($this->order[$column]);
        }

        $this->resetPage();
    }

    public function updatingEnabled()
    {
        $this->resetPage();
    }

    public function updatingLength()
    {
        $this->resetPage();
    }

    public function updatingRole()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}

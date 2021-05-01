<?php

namespace App\Http\Livewire\Backend;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UsersList extends Component
{
    use WithPagination;

    public $filtering = false;

    public $length = '10';

    public $order = ['created_at' => 'desc'];

    public $q;

    public $role;

    public function filter()
    {
        $this->filtering = !$this->filtering;
    }

    public function render()
    {
        $users = User::query();
        if ($this->q) {
            $users = $users->where(function (Builder $query) {
                $query->where('name', 'like', "%$this->q%")
                    ->orWhere('email', 'like', "%$this->q%");
            });
        }

        if ($this->role && Gate::check('viewAny', Role::class)) {
            $users->whereHas('roles', function ($query) {
                $query->whereKey($this->role);
            });
        }

        foreach ($this->order as $column => $direction) {
            $users = $users->orderBy($column, $direction);
        }

        $users = $users->paginate($this->length);
        return view('livewire.backend.users-list', compact('users'));
    }

    public function updatingLength()
    {
        $this->resetPage();
    }

    public function updatingRole()
    {
        $this->resetPage();
    }

    public function updatingQ()
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

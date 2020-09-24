<?php

namespace App\Http\Livewire\Backend;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class UsersList extends Component
{
    use WithPagination;

    public $length = '10';

    public $order = ['created_at' => 'asc'];

    public $q;

    public function render()
    {
        $users = User::query();
        if ($this->q) {
            $users = $users->where(function (Builder $query) {
                $query->where('name', 'like', "%$this->q%")
                    ->orWhere('email', 'like', "%$this->q%");
            });
        }

        foreach ($this->order as $column => $direction) {
            $users = $users->orderBy($column, $direction);
        }

        $users = $users->paginate($this->length);
        return view('livewire.backend.users-list', compact('users'));
    }

    public function resize($length)
    {
        $this->length = $length;
    }

    public function search($q)
    {
        $this->q = $q;
    }

    public function updatingLength()
    {
        $this->resetPage();
    }

    public function updatingSearch()
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
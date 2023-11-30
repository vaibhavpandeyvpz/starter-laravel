<?php

namespace App\Http\Livewire;

use Livewire\WithPagination;

trait WithDataTable
{
    use WithPagination;

    public $length = '10';

    public $order = ['created_at' => 'desc'];

    protected $paginationTheme = 'bootstrap';

    public $q;

    public function filter()
    {
        $this->filtering = ! $this->filtering;
    }

    /**
     * @param  string  $column
     * @param  string|false  $direction
     */
    public function sort($column, $direction)
    {
        if ($direction) {
            $this->order[$column] = $direction;
        } else {
            unset($this->order[$column]);
        }
    }

    public function updatingLength()
    {
        $this->resetPage();
    }

    public function updatingQ()
    {
        $this->resetPage();
    }
}
